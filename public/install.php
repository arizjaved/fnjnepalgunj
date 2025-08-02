<?php

// Define installation steps
$steps = [
    1 => 'Requirements',
    2 => 'Environment Setup',
    3 => 'Database Setup',
    4 => 'Admin User',
    5 => 'Finish',
];

// Get current step from query parameter or default to 1
$currentStep = isset($_GET['step']) ? (int)$_GET['step'] : 1;
if (!array_key_exists($currentStep, $steps)) {
    $currentStep = 1; // Fallback to first step if invalid
}

$errors = [];
$successMessage = '';
$output = ''; // To store command output

// Function to check PHP extensions
function checkExtension($extensionName) {
    return extension_loaded($extensionName);
}

// Function to check directory writability
function checkWritable($path) {
    // Check if the path exists and is writable
    if (file_exists($path)) {
        return is_writable($path);
    }
    // If path does not exist, check if its parent directory is writable (for creation)
    return is_writable(dirname($path));
}

// Function to get PHP version requirement from composer.json
function getPhpVersionRequirement() {
    $composerJsonPath = __DIR__ . '/../composer.json';
    if (file_exists($composerJsonPath)) {
        $composerConfig = json_decode(file_get_contents($composerJsonPath), true);
        if (isset($composerConfig['require']['php'])) {
            // Extract version constraint (e.g., ^8.1)
            $phpVersion = $composerConfig['require']['php'];
            // Remove common operators for display
            $phpVersion = str_replace(['^', '~', '>='], '', $phpVersion);
            return $phpVersion;
        }
    }
    return '8.1'; // Default if not found
}

// --- Handle POST requests ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($currentStep === 2) {
        // Process Environment Setup form
        $envContent = "APP_NAME=\"" . ($_POST['app_name'] ?? 'Laravel') . "\"\n";
        $envContent .= "APP_ENV=" . ($_POST['app_env'] ?? 'production') . "\n";
        $envContent .= "APP_KEY=base64:" . base64_encode(random_bytes(32)) . "\n"; // Generate new key
        $envContent .= "APP_DEBUG=" . ($_POST['app_debug'] ?? 'false') . "\n";
        $envContent .= "APP_URL=" . ($_POST['app_url'] ?? 'http://localhost') . "\n\n";

        $envContent .= "DB_CONNECTION=" . ($_POST['db_connection'] ?? 'mysql') . "\n";
        $envContent .= "DB_HOST=" . ($_POST['db_host'] ?? '127.0.0.1') . "\n";
        $envContent .= "DB_PORT=" . ($_POST['db_port'] ?? '3306') . "\n";
        $envContent .= "DB_DATABASE=\"" . ($_POST['db_database'] ?? '') . "\"\n";
        $envContent .= "DB_USERNAME=\"" . ($_POST['db_username'] ?? '') . "\"\n";
        $envContent .= "DB_PASSWORD=\"" . ($_POST['db_password'] ?? '') . "\"\n\n";

        // Add other default .env variables (simplified for this example)
        $envContent .= "BROADCAST_DRIVER=log\n";
        $envContent .= "CACHE_DRIVER=file\n";
        $envContent .= "FILESYSTEM_DISK=local\n";
        $envContent .= "QUEUE_CONNECTION=sync\n";
        $envContent .= "SESSION_DRIVER=file\n";
        $envContent .= "SESSION_LIFETIME=120\n\n";

        $envPath = __DIR__ . '/../.env';

        try {
            file_put_contents($envPath, $envContent);
            $successMessage = '.env file created successfully!';
            header('Location: ?step=3');
            exit();
        } catch (Exception $e) {
            $errors[] = 'Could not write to .env file. Please check permissions. ' . $e->getMessage();
        }
    } elseif ($currentStep === 3) {
        // Process Database Setup
        // Clear config cache first to ensure new .env is loaded
        $output .= shell_exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && php artisan config:clear 2>&1');
        $output .= shell_exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && php artisan cache:clear 2>&1');
        $output .= shell_exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && php artisan view:clear 2>&1');

        // Run migrations
        $migrateCommand = 'cd ' . escapeshellarg(__DIR__ . '/..') . ' && php artisan migrate --force 2>&1';
        $output .= shell_exec($migrateCommand);

        // Check if migrations were successful (simple check for now)
        if (strpos($output, 'Migration table created successfully.') !== false || strpos($output, 'Nothing to migrate.') !== false || strpos($output, 'Migrating:') !== false) {
            $successMessage = 'Database migrations ran successfully!';
            
            // Run seeders
            $seedCommand = 'cd ' . escapeshellarg(__DIR__ . '/..') . ' && php artisan db:seed --force 2>&1';
            $output .= shell_exec($seedCommand);

            if (strpos($output, 'Database seeding completed successfully.') !== false || strpos($output, 'Seeding:') !== false) {
                $successMessage .= ' Database seeded successfully!';
                header('Location: ?step=4');
                exit();
            } else {
                $errors[] = 'Database seeding failed. Check output for details.';
            }
        } else {
            $errors[] = 'Database migrations failed. Check output for details.';
        }
    } elseif ($currentStep === 4) {
        // Process Admin User form
        // Minimal Laravel bootstrapping to use Eloquent and Hash
        require_once __DIR__ . '/../vendor/autoload.php';
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        try {
            // Basic validation
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirmation'])) {
                throw new Exception('All fields are required.');
            }
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format.');
            }
            if ($_POST['password'] !== $_POST['password_confirmation']) {
                throw new Exception('Passwords do not match.');
            }
            if (strlen($_POST['password']) < 8) {
                throw new Exception('Password must be at least 8 characters.');
            }

            // Create user
            \App\Models\User::create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($_POST['password']),
                'role' => 'admin', // Assuming 'admin' role exists
            ]);

            $successMessage = 'Admin user created successfully!';
            header('Location: ?step=5');
            exit();

        } catch (Exception $e) {
            $errors[] = 'Failed to create admin user: ' . $e->getMessage();
        }
    }
} else if ($currentStep === 5) {
    // Attempt to delete the installer file
    $installerPath = __FILE__;
    if (file_exists($installerPath)) {
        if (unlink($installerPath)) {
            $successMessage = 'Installation complete! The installer file (install.php) has been successfully deleted.';
        } else {
            $errors[] = 'Installation complete, but failed to delete install.php. Please delete it manually for security reasons.';
        }
    }
}

// --- Step 1: Requirements Check ---
if ($currentStep === 1) {
    $phpRequired = getPhpVersionRequirement();
    $phpVersionOk = version_compare(PHP_VERSION, $phpRequired, '>=');

    $requirements = [
        'PHP Version (>= ' . $phpRequired . ')' => $phpVersionOk,
        'OpenSSL PHP Extension' => checkExtension('openssl'),
        'PDO PHP Extension' => checkExtension('pdo'),
        'Mbstring PHP Extension' => checkExtension('mbstring'),
        'Tokenizer PHP Extension' => checkExtension('tokenizer'),
        'XML PHP Extension' => checkExtension('xml'),
        'Ctype PHP Extension' => checkExtension('ctype'),
        'JSON PHP Extension' => checkExtension('json'),
        'BCMath PHP Extension' => checkExtension('bcmath'),
        'GD or Imagick PHP Extension' => checkExtension('gd') || checkExtension('imagick'),
        'Fileinfo PHP Extension' => checkExtension('fileinfo'),
        'cURL PHP Extension' => checkExtension('curl'),
    ];

    $permissions = [
        'Project Root (writable)' => checkWritable(__DIR__ . '/../'),
        'storage/ (writable)' => checkWritable(__DIR__ . '/../storage'),
        'bootstrap/cache/ (writable)' => checkWritable(__DIR__ . '/../bootstrap/cache'),
        '.env file (writable)' => checkWritable(__DIR__ . '/../.env') || !file_exists(__DIR__ . '/../.env'), // Check if .env exists or can be created
    ];

    $allRequirementsMet = true;
    foreach ($requirements as $req => $status) {
        if (!$status) $allRequirementsMet = false;
    }
    foreach ($permissions as $perm => $status) {
        if (!$status) $allRequirementsMet = false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .step-indicator.active {
            background-color: #0073b7;
            color: white;
        }
        .step-indicator.completed {
            background-color: #10B981; /* Green */
            color: white;
        }
        pre {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Laravel Installer</h1>
        
        <!-- Step Indicators -->
        <div class="flex justify-between mb-8">
            <?php foreach ($steps as $stepNum => $stepName): ?>
                <div class="flex-1 text-center">
                    <div class="step-indicator w-10 h-10 mx-auto rounded-full flex items-center justify-center text-lg font-semibold 
                        <?php echo $stepNum === $currentStep ? 'active' : ''; ?>
                        <?php echo $stepNum < $currentStep ? 'completed' : ''; ?>
                        <?php echo $stepNum > $currentStep ? 'bg-gray-200 text-gray-600' : ''; ?>">
                        <?php echo $stepNum; ?>
                    </div>
                    <p class="text-sm mt-2 text-gray-700"><?php echo $stepName; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Content Area -->
        <div class="border-t border-gray-200 pt-8">
            <?php if (!empty($errors)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline"><?php echo implode('<br>', $errors); ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($successMessage)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline"><?php echo $successMessage; ?></span>
                </div>
            <?php endif; ?>

            <?php if ($currentStep === 1): ?>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">1. Server Requirements</h2>
                <div class="space-y-3">
                    <?php foreach ($requirements as $req => $status): ?>
                        <div class="flex justify-between items-center p-3 rounded-md <?php echo $status ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
                            <span><?php echo $req; ?></span>
                            <?php if ($status): ?>
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-3">Folder Permissions</h3>
                <div class="space-y-3">
                    <?php foreach ($permissions as $perm => $status): ?>
                        <div class="flex justify-between items-center p-3 rounded-md <?php echo $status ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
                            <span><?php echo $perm; ?></span>
                            <?php if ($status): ?>
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-8 text-right">
                    <?php if ($allRequirementsMet): ?>
                        <a href="?step=2" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Continue to Environment Setup
                        </a>
                    <?php else: ?>
                        <p class="text-red-600 text-sm mb-4">Please fix the issues above before proceeding.</p>
                        <button onclick="location.reload()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Re-check Requirements
                        </button>
                    <?php endif; ?>
                </div>
            <?php elseif ($currentStep === 2): ?>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">2. Environment Setup</h2>
                <form method="POST" action="?step=2">
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-3">Application Settings</h3>
                        <div>
                            <label for="app_name" class="block text-sm font-medium text-gray-700">App Name</label>
                            <input type="text" name="app_name" id="app_name" value="<?php echo htmlspecialchars($_POST['app_name'] ?? 'FNJ Nepal'); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="app_url" class="block text-sm font-medium text-gray-700">App URL</label>
                            <input type="url" name="app_url" id="app_url" value="<?php echo htmlspecialchars($_POST['app_url'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="app_env" class="block text-sm font-medium text-gray-700">App Environment</label>
                            <select name="app_env" id="app_env" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="production" <?php echo (($_POST['app_env'] ?? 'production') === 'production') ? 'selected' : ''; ?>>Production</option>
                                <option value="local" <?php echo (($_POST['app_env'] ?? 'production') === 'local') ? 'selected' : ''; ?>>Local</option>
                            </select>
                        </div>
                        <div>
                            <label for="app_debug" class="block text-sm font-medium text-gray-700">App Debug Mode</label>
                            <select name="app_debug" id="app_debug" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="true" <?php echo (($_POST['app_debug'] ?? 'false') === 'true') ? 'selected' : ''; ?>>True</option>
                                <option value="false" <?php echo (($_POST['app_debug'] ?? 'false') === 'false') ? 'selected' : ''; ?>>False</option>
                            </select>
                        </div>

                        <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-3">Database Settings</h3>
                        <div>
                            <label for="db_connection" class="block text-sm font-medium text-gray-700">DB Connection</label>
                            <select name="db_connection" id="db_connection" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                <option value="mysql" <?php echo (($_POST['db_connection'] ?? 'mysql') === 'mysql') ? 'selected' : ''; ?>>MySQL</option>
                                <option value="pgsql" <?php echo (($_POST['db_connection'] ?? 'mysql') === 'pgsql') ? 'selected' : ''; ?>>PostgreSQL</option>
                                <option value="sqlite" <?php echo (($_POST['db_connection'] ?? 'mysql') === 'sqlite') ? 'selected' : ''; ?>>SQLite</option>
                            </select>
                        </div>
                        <div>
                            <label for="db_host" class="block text-sm font-medium text-gray-700">DB Host</label>
                            <input type="text" name="db_host" id="db_host" value="<?php echo htmlspecialchars($_POST['db_host'] ?? '127.0.0.1'); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="db_port" class="block text-sm font-medium text-gray-700">DB Port</label>
                            <input type="text" name="db_port" id="db_port" value="<?php echo htmlspecialchars($_POST['db_port'] ?? '3306'); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="db_database" class="block text-sm font-medium text-gray-700">DB Database</label>
                            <input type="text" name="db_database" id="db_database" value="<?php echo htmlspecialchars($_POST['db_database'] ?? ''); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="db_username" class="block text-sm font-medium text-gray-700">DB Username</label>
                            <input type="text" name="db_username" id="db_username" value="<?php echo htmlspecialchars($_POST['db_username'] ?? ''); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="db_password" class="block text-sm font-medium text-gray-700">DB Password</label>
                            <input type="password" name="db_password" id="db_password" value="<?php echo htmlspecialchars($_POST['db_password'] ?? ''); ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>

                    <div class="mt-8 text-right">
                        <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Save Environment & Continue
                        </button>
                    </div>
                </form>
            <?php elseif ($currentStep === 3): ?>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">3. Database Setup</h2>
                <p class="text-gray-600 mb-4">Click the button below to run database migrations and seeders. This may take a moment.</p>
                <form method="POST" action="?step=3">
                    <div class="mt-8 text-center">
                        <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Run Migrations & Seeders
                        </button>
                    </div>
                </form>
                <?php if (!empty($output)): ?>
                    <h3 class="text-xl font-semibold text-gray-700 mt-6 mb-3">Command Output:</h3>
                    <pre><?php echo htmlspecialchars($output); ?></pre>
                    <?php if (empty($errors)): ?>
                        <div class="mt-8 text-right">
                            <a href="?step=4" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                Continue to Admin User Setup
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="mt-8 text-right">
                            <button onclick="location.reload()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                Retry Database Setup
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php elseif ($currentStep === 4): ?>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">4. Admin User Setup</h2>
                <form method="POST" action="?step=4">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        </div>
                    </div>
                    <div class="mt-8 text-right">
                        <button type="submit" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                            Create Admin User
                        </button>
                    </div>
                </form>
            <?php elseif ($currentStep === 5): ?>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">5. Finish Installation</h2>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">Your Laravel application has been successfully installed!</span>
                </div>
                <p class="text-red-600 text-center text-lg font-semibold mb-4">SECURITY WARNING: Please delete the 'install.php' file from your public directory IMMEDIATELY!</p>
                <div class="mt-8 text-center">
                    <a href="/" class="bg-[#0073b7] hover:bg-[#004a7f] text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        Go to Application
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>