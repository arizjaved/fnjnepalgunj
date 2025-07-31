<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Preserve query parameters in pagination links
        $users->appends($request->query());
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active');

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        // Get user's content statistics
        $stats = [
            'news_count' => $user->hasMany(\App\Models\News::class, 'created_by')->count(),
            'press_releases_count' => $user->hasMany(\App\Models\PressRelease::class, 'created_by')->count(),
            'notices_count' => $user->hasMany(\App\Models\Notice::class, 'created_by')->count(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        // Prevent editing own account through this interface
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('warning', 'You cannot edit your own account through this interface.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Prevent editing own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot edit your own account.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,editor',
            'is_active' => 'boolean',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot delete your own account.');
        }

        // Check if user has created content
        $hasContent = $user->hasMany(\App\Models\News::class, 'created_by')->exists() ||
                     $user->hasMany(\App\Models\PressRelease::class, 'created_by')->exists() ||
                     $user->hasMany(\App\Models\Notice::class, 'created_by')->exists();

        if ($hasContent) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot delete user who has created content. Please reassign their content first.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent deactivating own account
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.users.index')
                        ->with('success', "User {$status} successfully.");
    }
}
