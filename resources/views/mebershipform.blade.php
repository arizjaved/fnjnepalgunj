@extends('layouts.app')

@section('title', 'Nepal Press Association - Membership Form')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 rounded-t-lg">
            <h1 class="text-2xl font-bold text-center">Nepal Press Association</h1>
            <h2 class="text-lg text-center mt-2">Membership Application Form</h2>
        </div>

        <!-- Progress Bar -->
        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-600" id="progress-text">Step 1 of 6</span>
                <span class="text-sm text-gray-500" id="progress-percentage">17%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" id="progress-bar" style="width: 17%"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-500">
                <span class="step-label active">Application Type</span>
                <span class="step-label">Personal Info</span>
                <span class="step-label">Education</span>
                <span class="step-label">Employment</span>
                <span class="step-label">Documents</span>
                <span class="step-label">Review</span>
            </div>
        </div>

        <form action="{{ route('membership.store') }}" method="POST" enctype="multipart/form-data" id="membership-form">
            @csrf
            
            <!-- Step 1: Application Type -->
            <div class="form-step active" id="step-1">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Application Type</h3>
                    
                    <div class="space-y-4">
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors application-type-card" data-type="new">
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="application_type" value="new" class="form-radio text-blue-600 mt-1" required>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">New Membership</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Apply for first-time membership in Nepal Press Association. 
                                        You must be actively working in journalism.
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-colors application-type-card" data-type="renewal">
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="application_type" value="renewal" class="form-radio text-blue-600 mt-1" required>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Membership Renewal</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        Renew your existing membership. You must have been a previous member 
                                        and continue to work in journalism.
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Renewal specific field -->
                    <div id="renewal-fields" class="mt-4 hidden">
                        <div>
                            <label for="previous_membership_id" class="block text-sm font-medium text-gray-700 mb-1">Previous Membership ID</label>
                            <input type="text" id="previous_membership_id" name="previous_membership_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Personal Information -->
            <div class="form-step" id="step-2">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Personal Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth *</label>
                            <input type="date" id="birth_date" name="birth_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="form-radio text-blue-600" required>
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="form-radio text-blue-600" required>
                                <span class="ml-2">Female</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="other" class="form-radio text-blue-600" required>
                                <span class="ml-2">Other</span>
                            </label>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Complete Address *</label>
                        <textarea id="address" name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="phone_home" class="block text-sm font-medium text-gray-700 mb-1">Home Phone</label>
                            <input type="tel" id="phone_home" name="phone_home" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile *</label>
                            <input type="tel" id="mobile" name="mobile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Personal Website/Blog</label>
                        <input type="url" id="website" name="website" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Step 3: Education & Social Groups -->
            <div class="form-step" id="step-3">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Education & Background</h3>
                    
                    <div class="mb-6">
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">Educational Qualification *</label>
                        <select id="education" name="education" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Select Education Level</option>
                            <option value="slc">SLC/SEE</option>
                            <option value="certificate">Certificate Level</option>
                            <option value="bachelor">Bachelor's Degree</option>
                            <option value="masters">Master's Degree</option>
                            <option value="phd">PhD</option>
                        </select>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Social Group (Select if applicable)</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="indigenous" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Indigenous</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="janajati" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Janajati</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="dalit" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Dalit</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="madhesi" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Madhesi</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="women" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Women</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="checkbox" name="social_groups[]" value="karnali" class="form-checkbox text-blue-600">
                                <span class="ml-2 text-sm">Karnali</span>
                            </label>
                        </div>
                    </div>

                    <!-- Other Profession Section -->
                    <div class="border-t pt-6">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Other Profession (if any)</h4>
                        
                        <div class="mb-4">
                            <label for="other_profession" class="block text-sm font-medium text-gray-700 mb-1">What other profession are you engaged in?</label>
                            <input type="text" id="other_profession" name="other_profession" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div id="other-profession-details" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status of Other Profession</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_profession_status" value="contract" class="form-radio text-blue-600">
                                    <span class="ml-2">Contract</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_profession_status" value="temporary" class="form-radio text-blue-600">
                                    <span class="ml-2">Temporary</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_profession_status" value="permanent" class="form-radio text-blue-600">
                                    <span class="ml-2">Permanent</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_profession_status" value="other" class="form-radio text-blue-600">
                                    <span class="ml-2">Other</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Employment Details -->
            <div class="form-step" id="step-4">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Current Employment Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="md:col-span-2">
                            <label for="organization_name" class="block text-sm font-medium text-gray-700 mb-1">Organization Name & Address *</label>
                            <textarea id="organization_name" name="organization_name" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="org_phone" class="block text-sm font-medium text-gray-700 mb-1">Organization Phone</label>
                            <input type="tel" id="org_phone" name="org_phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="org_fax" class="block text-sm font-medium text-gray-700 mb-1">Fax</label>
                            <input type="tel" id="org_fax" name="org_fax" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="org_email" class="block text-sm font-medium text-gray-700 mb-1">Organization Email</label>
                            <input type="email" id="org_email" name="org_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="publication_name" class="block text-sm font-medium text-gray-700 mb-1">Publication Name *</label>
                            <input type="text" id="publication_name" name="publication_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label for="publication_website" class="block text-sm font-medium text-gray-700 mb-1">Publication Website</label>
                            <input type="url" id="publication_website" name="publication_website" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Publication Type -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Publication Type *</label>
                        <div class="space-y-4">
                            <div class="border rounded-lg p-4">
                                <div class="font-medium text-gray-700 mb-2">Print Media</div>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="daily" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Daily</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="weekly" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Weekly</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="fortnightly" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Fortnightly</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="monthly" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Monthly</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="other_print" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Other</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <div class="font-medium text-gray-700 mb-2">Electronic Media</div>
                                <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="radio" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Radio</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="television" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Television</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="online" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Online</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="news_agency" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">News Agency</span>
                                    </label>
                                    <label class="flex items-center p-2 border rounded hover:bg-gray-50">
                                        <input type="radio" name="publication_type" value="other_electronic" class="form-radio text-blue-600" required>
                                        <span class="ml-2 text-sm">Other</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position *</label>
                            <input type="text" id="position" name="position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                        <div>
                            <label for="work_start_date" class="block text-sm font-medium text-gray-700 mb-1">Work Start Date *</label>
                            <input type="date" id="work_start_date" name="work_start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Employment Type *</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="radio" name="employment_type" value="permanent" class="form-radio text-blue-600" required>
                                <span class="ml-2">Permanent</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="radio" name="employment_type" value="temporary" class="form-radio text-blue-600" required>
                                <span class="ml-2">Temporary</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="radio" name="employment_type" value="contract" class="form-radio text-blue-600" required>
                                <span class="ml-2">Contract</span>
                            </label>
                            <label class="inline-flex items-center p-2 border rounded-md hover:bg-gray-50">
                                <input type="radio" name="employment_type" value="other_employment" class="form-radio text-blue-600" required>
                                <span class="ml-2">Other</span>
                            </label>
                        </div>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Documents & Recommenders -->
            <div class="form-step" id="step-5">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Documents & Recommenders</h3>
                    
                    <!-- Required Documents -->
                    <div class="mb-8">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Required Documents</h4>
                        
                        <div class="space-y-4">
                            <div class="border rounded-lg p-4">
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Passport Size Photo *</label>
                                <input type="file" id="photo" name="photo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: JPG, PNG (Max size: 2MB)</p>
                                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <label for="education_certificate" class="block text-sm font-medium text-gray-700 mb-2">Educational Certificate (Certified Copy) *</label>
                                <input type="file" id="education_certificate" name="education_certificate" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max size: 5MB)</p>
                                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <label for="appointment_letter" class="block text-sm font-medium text-gray-700 mb-2">Appointment Letter (Certified Copy) *</label>
                                <input type="file" id="appointment_letter" name="appointment_letter" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max size: 5MB)</p>
                                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <label for="citizenship" class="block text-sm font-medium text-gray-700 mb-2">Citizenship Certificate (Certified Copy) *</label>
                                <input type="file" id="citizenship" name="citizenship" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max size: 5MB)</p>
                                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <label for="work_samples" class="block text-sm font-medium text-gray-700 mb-2">Published/Broadcast News Samples (Last 3 years) *</label>
                                <input type="file" id="work_samples" name="work_samples[]" accept=".pdf,.jpg,.jpeg,.png" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <p class="text-xs text-gray-500 mt-1">You can select multiple files. Accepted formats: PDF, JPG, PNG (Max size per file: 5MB)</p>
                                <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                            </div>
                            
                            <div class="border rounded-lg p-4">
                                <label for="experience_letter" class="block text-sm font-medium text-gray-700 mb-2">Experience Letter (Optional)</label>
                                <input type="file" id="experience_letter" name="experience_letter" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, JPG, PNG (Max size: 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommenders -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Recommenders</h4>
                        <p class="text-sm text-gray-600 mb-4">Two current members of Nepal Press Association must recommend your application.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h5 class="font-medium text-gray-800 mb-3">First Recommender *</h5>
                                <div class="space-y-3">
                                    <div>
                                        <label for="recommender1_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                        <input type="text" id="recommender1_name" name="recommender1_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender1_branch" class="block text-sm font-medium text-gray-700 mb-1">Branch</label>
                                        <input type="text" id="recommender1_branch" name="recommender1_branch" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender1_position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                        <input type="text" id="recommender1_position" name="recommender1_position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender1_id" class="block text-sm font-medium text-gray-700 mb-1">Association ID Number</label>
                                        <input type="text" id="recommender1_id" name="recommender1_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="border rounded-lg p-4 bg-gray-50">
                                <h5 class="font-medium text-gray-800 mb-3">Second Recommender *</h5>
                                <div class="space-y-3">
                                    <div>
                                        <label for="recommender2_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                        <input type="text" id="recommender2_name" name="recommender2_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender2_branch" class="block text-sm font-medium text-gray-700 mb-1">Branch</label>
                                        <input type="text" id="recommender2_branch" name="recommender2_branch" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender2_position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                        <input type="text" id="recommender2_position" name="recommender2_position" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                    <div>
                                        <label for="recommender2_id" class="block text-sm font-medium text-gray-700 mb-1">Association ID Number</label>
                                        <input type="text" id="recommender2_id" name="recommender2_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 6: Review & Submit -->
            <div class="form-step" id="step-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Review & Submit</h3>
                    
                    <!-- Application Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Application Summary</h4>
                        <div id="application-summary" class="space-y-3">
                            <!-- Summary will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Declaration -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <label class="inline-flex items-start">
                            <input type="checkbox" name="declaration" id="declaration" class="form-checkbox text-blue-600 mt-1" required>
                            <span class="ml-3 text-sm text-gray-700">
                                <strong>Declaration:</strong> I declare that I accept the constitution of Nepal Press Association and agree to abide by the rules and regulations made by the association from time to time. I also declare that all the information provided in this form is true and accurate to the best of my knowledge. I understand that providing false information may result in rejection of my application or cancellation of membership.
                            </span>
                        </label>
                        <div class="error-message text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <!-- Important Notice -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h5 class="font-semibold text-yellow-800 mb-2">Important Notes:</h5>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Only journalists actively working in journalism are eligible for membership</li>
                            <li>• All documents must be clear and readable</li>
                            <li>• Application will be processed after verification of all documents</li>
                            <li>• Non-journalists will not be granted membership</li>
                            <li>• Processing time may take 15-30 working days</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <button type="button" id="prev-btn" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 hidden">
                    Previous
                </button>
                <div class="flex space-x-3">
                    <button type="button" id="save-draft-btn" class="px-6 py-2 border border-blue-300 text-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save Draft
                    </button>
                    <button type="button" id="next-btn" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Next
                    </button>
                    <button type="submit" id="submit-btn" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 hidden">
                        Submit Application
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
    .step-label {
        transition: all 0.3s ease;
    }
    .step-label.active {
        color: #2563eb;
        font-weight: 600;
    }
    .step-label.completed {
        color: #16a34a;
    }
    .application-type-card.selected {
        border-color: #2563eb;
        background-color: #eff6ff;
    }
    .error-input {
        border-color: #ef4444;
        background-color: #fef2f2;
    }
    .success-input {
        border-color: #22c55e;
        background-color: #f0fdf4;
    }
</style>
@endpush

@push('scripts')
<script>
class MultiStepForm {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 6;
        this.formData = {};
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateProgress();
        this.loadDraftData();
    }

    bindEvents() {
        // Navigation buttons
        document.getElementById('next-btn').addEventListener('click', () => this.nextStep());
        document.getElementById('prev-btn').addEventListener('click', () => this.prevStep());
        document.getElementById('save-draft-btn').addEventListener('click', () => this.saveDraft());

        // Application type selection
        document.querySelectorAll('input[name="application_type"]').forEach(radio => {
            radio.addEventListener('change', (e) => {
                document.querySelectorAll('.application-type-card').forEach(card => {
                    card.classList.remove('selected');
                });
                e.target.closest('.application-type-card').classList.add('selected');
                
                // Show/hide renewal fields
                const renewalFields = document.getElementById('renewal-fields');
                if (e.target.value === 'renewal') {
                    renewalFields.classList.remove('hidden');
                    document.getElementById('previous_membership_id').required = true;
                } else {
                    renewalFields.classList.add('hidden');
                    document.getElementById('previous_membership_id').required = false;
                }
            });
        });

        // Other profession toggle
        document.getElementById('other_profession').addEventListener('input', (e) => {
            const details = document.getElementById('other-profession-details');
            if (e.target.value.trim()) {
                details.classList.remove('hidden');
            } else {
                details.classList.add('hidden');
            }
        });

        // Form validation on input
        this.bindValidationEvents();
    }

    bindValidationEvents() {
        const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Basic required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
        }

        // Phone validation
        if (field.type === 'tel' && value && field.hasAttribute('required')) {
            const phoneRegex = /^[0-9+\-\s()]+$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number.';
            }
        }

        // Date validation
        if (field.type === 'date' && value) {
            const date = new Date(value);
            const today = new Date();
            
            if (fieldName === 'birth_date') {
                const age = (today - date) / (365 * 24 * 60 * 60 * 1000);
                if (age < 18) {
                    isValid = false;
                    errorMessage = 'You must be at least 18 years old.';
                }
            }
            
            if (fieldName === 'work_start_date') {
                if (date > today) {
                    isValid = false;
                    errorMessage = 'Work start date cannot be in the future.';
                }
            }
        }

        // File validation
        if (field.type === 'file' && field.files.length > 0) {
            const file = field.files[0];
            const maxSize = fieldName === 'photo' ? 2 * 1024 * 1024 : 5 * 1024 * 1024; // 2MB for photo, 5MB for others
            
            if (file.size > maxSize) {
                isValid = false;
                const maxSizeMB = maxSize / (1024 * 1024);
                errorMessage = `File size must be less than ${maxSizeMB}MB.`;
            }
        }

        this.showFieldValidation(field, isValid, errorMessage);
        return isValid;
    }

    showFieldValidation(field, isValid, errorMessage) {
        const errorDiv = field.parentNode.querySelector('.error-message');
        
        if (isValid) {
            field.classList.remove('error-input');
            field.classList.add('success-input');
            if (errorDiv) errorDiv.classList.add('hidden');
        } else {
            field.classList.remove('success-input');
            field.classList.add('error-input');
            if (errorDiv) {
                errorDiv.textContent = errorMessage;
                errorDiv.classList.remove('hidden');
            }
        }
    }

    clearFieldError(field) {
        field.classList.remove('error-input');
        const errorDiv = field.parentNode.querySelector('.error-message');
        if (errorDiv) errorDiv.classList.add('hidden');
    }

    validateStep(stepNumber) {
        const step = document.getElementById(`step-${stepNumber}`);
        const requiredFields = step.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        // Special validation for radio button groups
        const radioGroups = {};
        step.querySelectorAll('input[type="radio"][required]').forEach(radio => {
            if (!radioGroups[radio.name]) {
                radioGroups[radio.name] = [];
            }
            radioGroups[radio.name].push(radio);
        });

        Object.keys(radioGroups).forEach(groupName => {
            const group = radioGroups[groupName];
            const isChecked = group.some(radio => radio.checked);
            
            if (!isChecked) {
                isValid = false;
                // Show error for radio group
                const errorDiv = group[0].closest('div').querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.textContent = 'Please select an option.';
                    errorDiv.classList.remove('hidden');
                }
            }
        });

        return isValid;
    }

    nextStep() {
        if (!this.validateStep(this.currentStep)) {
            this.showNotification('Please correct the errors before proceeding.', 'error');
            return;
        }

        this.saveFormData();

        if (this.currentStep < this.totalSteps) {
            this.currentStep++;
            this.showStep(this.currentStep);
            this.updateProgress();
            
            if (this.currentStep === this.totalSteps) {
                this.populateReviewSummary();
            }
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.showStep(this.currentStep);
            this.updateProgress();
        }
    }

    showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });
        
        // Show current step
        document.getElementById(`step-${stepNumber}`).classList.add('active');
        
        // Update navigation buttons
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        
        prevBtn.classList.toggle('hidden', stepNumber === 1);
        nextBtn.classList.toggle('hidden', stepNumber === this.totalSteps);
        submitBtn.classList.toggle('hidden', stepNumber !== this.totalSteps);
        
        // Scroll to top
        window.scrollTo(0, 0);
    }

    updateProgress() {
        const progress = (this.currentStep / this.totalSteps) * 100;
        document.getElementById('progress-bar').style.width = `${progress}%`;
        document.getElementById('progress-text').textContent = `Step ${this.currentStep} of ${this.totalSteps}`;
        document.getElementById('progress-percentage').textContent = `${Math.round(progress)}%`;
        
        // Update step labels
        document.querySelectorAll('.step-label').forEach((label, index) => {
            label.classList.remove('active', 'completed');
            if (index + 1 === this.currentStep) {
                label.classList.add('active');
            } else if (index + 1 < this.currentStep) {
                label.classList.add('completed');
            }
        });
    }

    saveFormData() {
        const formData = new FormData(document.getElementById('membership-form'));
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (data[key]) {
                if (Array.isArray(data[key])) {
                    data[key].push(value);
                } else {
                    data[key] = [data[key], value];
                }
            } else {
                data[key] = value;
            }
        }
        
        this.formData = data;
    }

    saveDraft() {
        this.saveFormData();
        // In a real application, you would send this to the server
        try {
            localStorage.setItem('membership_form_draft', JSON.stringify(this.formData));
            this.showNotification('Draft saved successfully!', 'success');
        } catch (error) {
            console.log('Draft save simulation:', this.formData);
            this.showNotification('Draft saved successfully!', 'success');
        }
    }

    loadDraftData() {
        try {
            const draftData = localStorage.getItem('membership_form_draft');
            if (draftData) {
                const data = JSON.parse(draftData);
                // Populate form fields with draft data
                Object.keys(data).forEach(key => {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field && field.type !== 'file') {
                        if (field.type === 'radio' || field.type === 'checkbox') {
                            if (field.value === data[key] || (Array.isArray(data[key]) && data[key].includes(field.value))) {
                                field.checked = true;
                            }
                        } else {
                            field.value = data[key];
                        }
                    }
                });
                this.showNotification('Draft data loaded!', 'info');
            }
        } catch (error) {
            console.log('No draft data available');
        }
    }

    populateReviewSummary() {
        const summaryDiv = document.getElementById('application-summary');
        const formData = new FormData(document.getElementById('membership-form'));
        
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">';
        
        // Personal Information
        html += '<div><strong>Full Name:</strong> ' + (formData.get('full_name') || 'Not provided') + '</div>';
        html += '<div><strong>Email:</strong> ' + (formData.get('email') || 'Not provided') + '</div>';
        html += '<div><strong>Mobile:</strong> ' + (formData.get('mobile') || 'Not provided') + '</div>';
        html += '<div><strong>Application Type:</strong> ' + (formData.get('application_type') || 'Not selected') + '</div>';
        html += '<div><strong>Education:</strong> ' + (formData.get('education') || 'Not selected') + '</div>';
        html += '<div><strong>Organization:</strong> ' + (formData.get('organization_name') || 'Not provided') + '</div>';
        html += '<div><strong>Publication:</strong> ' + (formData.get('publication_name') || 'Not provided') + '</div>';
        html += '<div><strong>Position:</strong> ' + (formData.get('position') || 'Not provided') + '</div>';
        
        html += '</div>';
        summaryDiv.innerHTML = html;
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-md z-50 ${
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new MultiStepForm();
    
    // Form submission
    document.getElementById('membership-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Final validation
        if (!document.getElementById('declaration').checked) {
            alert('Please accept the declaration to submit the form.');
            return;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        // In a real application, submit the form data
        setTimeout(() => {
            alert('Application submitted successfully! You will receive a confirmation email shortly.');
            // Reset form or redirect
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Application';
        }, 2000);
    });
});
</script>
@endpush
@endsection