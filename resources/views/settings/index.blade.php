@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Settings</h2>
                <nav class="space-y-2">
                    <a href="#profile" class="settings-nav-link active">Profile Settings</a>
                    <a href="#notifications" class="settings-nav-link">Notifications</a>
                    <a href="#payment" class="settings-nav-link">Payment Methods</a>
                    <a href="#preferences" class="settings-nav-link">Preferences</a>
                    <a href="#security" class="settings-nav-link">Security</a>
                    @if(Auth::user()->role === 'landlord')
                        <a href="#landlord" class="settings-nav-link">Landlord Settings</a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            @php
                $user = Auth::user();
                $prefix = $user->role ?? ($user->landlord_id ? 'tenant' : 'landlord');
            @endphp

            <!-- Profile Settings Section -->
            <div id="profile" class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Profile Settings</h3>
                
                <form method="POST" action="{{ route($prefix . '.settings.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                            <div class="flex items-center">
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" 
                                     class="w-16 h-16 rounded-full mr-4">
                                <div>
                                    <input type="file" name="profile_photo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notifications Section -->
            <div id="notifications" class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Notification Preferences</h3>
                
                <form method="POST" action="{{ route($prefix . '.settings.notifications.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-800">Payment Reminders</h4>
                                <p class="text-sm text-gray-600">Get notified before rent payments are due</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="payment_reminders" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-800">Maintenance Updates</h4>
                                <p class="text-sm text-gray-600">Receive updates on maintenance requests</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_updates" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-800">Lease Expiration</h4>
                                <p class="text-sm text-gray-600">Get notified before lease agreements expire</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="lease_expiration" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- Payment Methods Section -->
            <div id="payment" class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Payment Methods</h3>
                
                <div class="mb-6">
                    <h4 class="font-medium text-gray-800 mb-4">Saved Payment Methods</h4>
                    <div class="border rounded-lg">
                        <div class="p-4 border-b flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="bg-gray-100 p-3 rounded-lg mr-4">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium">Visa ending in 4242</div>
                                    <div class="text-sm text-gray-600">Expires 12/2025</div>
                                </div>
                            </div>
                            <div>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Default</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    + Add Payment Method
                </button>
            </div>

            <!-- Preferences Section -->
            <div id="preferences" class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Preferences</h3>
                
                <form method="POST" action="{{ route($prefix . '.settings.preferences.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Language</label>
                            <select name="language" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="en" selected>English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                            <select name="currency" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="USD" selected>USD - US Dollar</option>
                                <option value="EUR">EUR - Euro</option>
                                <option value="GBP">GBP - British Pound</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                            <select name="date_format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="MM/DD/YYYY" selected>MM/DD/YYYY</option>
                                <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Time Zone</label>
                            <select name="timezone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="America/New_York" selected>Eastern Time (ET)</option>
                                <option value="America/Chicago">Central Time (CT)</option>
                                <option value="America/Denver">Mountain Time (MT)</option>
                                <option value="America/Los_Angeles">Pacific Time (PT)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Preferences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Section -->
            <div id="security" class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Security</h3>
                
                <div class="space-y-6">
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">Change Password</h4>
                        
                        <form method="POST" action="{{ route($prefix . '.settings.password.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="new_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="flex items-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">Two-Factor Authentication</h4>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <div class="font-medium">Two-factor authentication is disabled</div>
                                <div class="text-sm text-gray-600">Add an extra layer of security to your account</div>
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Enable
                            </button>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-800 mb-2">Active Sessions</h4>
                        <div class="border rounded-lg">
                            <div class="p-4 border-b">
                                <div class="flex justify-between">
                                    <div>
                                        <div class="font-medium">Current Session</div>
                                        <div class="text-sm text-gray-600">Chrome on Windows • New York, US</div>
                                    </div>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Current</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Signed in: Today at 9:30 AM</div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between">
                                    <div>
                                        <div class="font-medium">Chrome on macOS</div>
                                        <div class="text-sm text-gray-600">San Francisco, US</div>
                                    </div>
                                    <button class="text-red-600 hover:text-red-800 text-sm">Revoke</button>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Signed in: Yesterday at 3:15 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Landlord Specific Settings -->
            @if(Auth::user()->role === 'landlord')
            <div id="landlord" class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Landlord Settings</h3>
                
                <form method="POST" action="{{ route($prefix . '.settings.landlord.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-medium text-gray-800 mb-4">Property Management</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div>
                                        <div class="font-medium">Auto-generate monthly payments</div>
                                        <div class="text-sm text-gray-600">Automatically create rent payments for all properties</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="auto_generate_payments" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div>
                                        <div class="font-medium">Send lease renewal reminders</div>
                                        <div class="text-sm text-gray-600">Notify tenants 30 days before lease expiration</div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="lease_renewal_reminders" class="sr-only peer" checked>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-800 mb-4">Financial Settings</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Late Fee</label>
                                    <input type="text" name="default_late_fee" value="$50" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Late Fee Grace Period (days)</label>
                                    <input type="number" name="late_fee_grace_period" value="3" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Landlord Settings
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.settings-nav-link {
    @apply block px-4 py-2 text-gray-700 rounded-lg transition-colors duration-200;
}

.settings-nav-link:hover {
    @apply bg-gray-100 text-gray-900;
}

.settings-nav-link.active {
    @apply bg-blue-50 text-blue-700 font-medium;
}
</style>

<script>
// Smooth scrolling for navigation links
document.querySelectorAll('.settings-nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all links
        document.querySelectorAll('.settings-nav-link').forEach(l => {
            l.classList.remove('active');
        });
        
        // Add active class to clicked link
        this.classList.add('active');
        
        // Scroll to section
        const targetId = this.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Highlight active section on scroll
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.bg-white');
    const navLinks = document.querySelectorAll('.settings-nav-link');
    
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (pageYOffset >= (sectionTop - 100)) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
});
</script>
@endsection