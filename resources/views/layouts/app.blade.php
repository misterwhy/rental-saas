<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Property Management Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-64 shadow-sm flex-shrink-0 border-r border-gray-200" style="background-color: #eae9e3;">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center mb-10 pl-2">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center">
                        <svg height="496pt" viewBox="0 -52 496.61632 496" width="496pt" xmlns="http://www.w3.org/2000/svg">
                            <path d="m105.765625 81.90625c-1.203125-.398438-2.402344-.398438-3.601563-.398438-5.601562 0-10.398437 3.601563-12 9.199219-.800781 3.199219-.398437 6.402344 1.199219 9.199219 1.601563 2.800781 4.402344 4.800781 7.601563 6 6.800781 2 13.597656-2 15.597656-8.398438.800781-3.199218.402344-6.398437-1.199219-9.199218-1.597656-3.199219-4.398437-5.199219-7.597656-6.402344zm0 0"></path>
                            <path d="m173.363281 140.308594c11.199219 0 22-2.800782 31.601563-8.402344 4-2.398438 8.800781-1.199219 11.199218 2.800781 2.398438 4 1.199219 8.800781-2.800781 11.199219-12 7.203125-26 10.800781-40 10.800781-2.398437 0-4.800781 0-7.199219-.398437"></path>
                            <path d="m135.363281 127.507812c10.402344 8 23.199219 12.398438 36.402344 12.800782 9.199219-40-15.203125-80.800782-55.601563-92-4-1.199219-8-1.601563-11.601562-2.402344l13.203125 5.601562c-2.402344 4.800782-4 10-5.203125 15.601563 6.800781 2.398437 12.402344 6.796875 16 13.199219 3.601562 6.800781 4.800781 14.398437 2.800781 21.597656-3.597656 12.800781-15.199219 20.800781-28 20.800781-2.398437 0-5.199219-.398437-8-1.199219-7.597656-2-13.597656-6.800781-17.597656-13.601562-3.601563-6.796875-4.800781-14.398438-2.800781-21.597656 2.800781-10.402344 11.199218-17.601563 20.800781-20 1.199219-7.199219 3.199219-14 6.398437-20.800782-16-1.601562-31.601562 1.601563-46 9.601563-18.398437 10.398437-31.601562 26.796875-37.601562 47.199219-9.199219 30.800781.800781 62.800781 24.800781 82 1.199219 1.199218 1.601563 2.800781 1.199219 4l-16 61.199218c0 1.199219 0 2 .402344 2.800782l9.199218 20.800781c.800782 2 0 4-1.601562 5.199219l-15.199219 10c-1.597656 1.199218-2.398437 3.199218-1.597656 5.199218l7.597656 16c.800781 2 .402344 4-1.597656 5.199219l-14.800781 9.601563c-1.601563 1.199218-2.402344 3.199218-1.601563 5.199218l7.601563 16c.800781 2 0 4.398438-1.601563 5.199219l-13.199219 7.199219c-2 1.203125-2.800781 3.601562-1.601562 5.601562l14.800781 26.800782c.402344.800781 1.601563 1.597656 2.402344 2h1.199219c.800781 0 1.597656 0 2-.402344l30.800781-18c.796875-.398438 1.597656-1.199219 2-2.398438l47.597656-163.601562c.402344-1.597656 1.601563-2.796875 3.199219-2.796875 25.601562-3.601563 49.203125-22.800781 60.800781-48.402344-14.800781-1.199219-29.199219-6.800781-41.199219-16-3.601562-2.800781-4.398437-8-1.601562-11.597656 4-3.601563 9.203125-4.402344 12.800781-1.601563zm0 0"></path>
                            <path d="m101.765625 45.109375c12.796875-26.402344 40.398437-44.800781 71.597656-44.800781 36.800781 0 69.199219 26 77.199219 61.199218.800781 4.398438-2 8.800782-6.398438 9.601563-4.398437.796875-8.800781-2-10-6.402344-6.398437-28-32-48.398437-61.199218-48.398437-24.402344 0-46 14-56.402344 34.800781"></path>
                            <path d="m494.164062 213.90625-140.398437-138.796875c-3.203125-3.203125-12-10.402344-22.402344-10.800781l-90.800781-8.402344c-.398438 0-.398438 0-.796875 0h-2c-9.601563 0-17.601563 3.601562-24.800781 10.800781-7.601563 7.601563-10.800782 15.601563-10.800782 26.800781v.800782l8 90c0 10.398437 7.601563 18.800781 10.800782 22l140.398437 138.800781c1.601563 1.597656 3.601563 2.398437 6 2.398437 2.402344 0 4.402344-.800781 6-2.398437l121.199219-119.601563c2.800781-3.199218 2.800781-8.398437-.398438-11.601562zm-189.199218-9.597656c-2 0-4.402344-.800782-6-2.402344-3.199219-3.199219-3.199219-8.398438 0-11.597656l40-39.601563c3.199218-3.199219 8.398437-3.199219 11.597656 0 3.203125 3.199219 3.203125 8.402344 0 11.601563l-40 39.597656c-1.597656 1.601562-3.597656 2.402344-5.597656 2.402344zm92.398437 4-40 39.597656c-1.597656 1.601562-3.597656 2.402344-6 2.402344-2.398437 0-4.398437-.800782-6-2.402344-3.199219-3.199219-3.199219-8.398438 0-11.597656l40-39.601563c3.199219-3.199219 8.402344-3.199219 11.601563 0 3.597656 3.199219 3.597656 8.402344.398437 11.601563zm0 0"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800 ml-2">RentPro</span>
                </div>
                
                <!-- Navigation -->
                <nav class="space-y-1">
                    @if(Auth::user()->user_type === 'landlord')
                        <a href="{{ route('landlord.dashboard') }}" 
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('landlord.dashboard') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('landlord.properties.index') }}" 
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('landlord.properties.*') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Properties</span>
                        </a>
                        
                        <a href="{{ route('landlord.rent-payments.index') }}"
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('landlord.rent-payments.*') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Rent Payments</span>
                        </a>
                        
                        <a href="{{ route('landlord.analytics.index') }}"
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('landlord.analytics.index') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6m-6 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Analytics</span>
                        </a>
                    @elseif(Auth::user()->user_type === 'tenant')
                        <a href="{{ route('tenant.dashboard') }}" 
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('tenant.dashboard') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">My Dashboard</span>
                        </a>
                        
                        <a href="{{ route('tenant.properties.index') }}"
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('tenant.properties.*') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">My Property</span>
                        </a>
                        
                        <a href="{{ route('tenant.rent-payments.index') }}" 
                        class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                                {{ request()->routeIs('tenant.payments.*') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                            <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">My Payments</span>
                        </a>
                    @endif
                    
                    <a href="{{ route('landlord.profile.show') }}" 
                    class="flex items-center p-3 text-gray-600 rounded-3xl transition-colors duration-200
                            {{ request()->routeIs('profile.*') ? 'bg-gray-600 text-white' : 'hover:bg-gray-600 hover:text-white' }}">
                        <div class="sidebar-icon rounded-lg p-1.5 mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Profile</span>
                    </a>
                    
                    <a href="{{ Auth::user()->role === 'landlord' ? route('landlord.settings.index') : route('tenant.settings.index') }}" 
                    class="flex items-center p-3 text-gray-600 hover:bg-gray-600 hover:text-white rounded-3xl transition-colors duration-200">
                        <div class="sidebar-icon rounded-lg p-1.5 mr-3 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Settings</span>
                    </a>
                    
                    <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-600 hover:text-white rounded-3xl transition-colors duration-200">
                        <div class="sidebar-icon rounded-lg p-1.5 mr-3 hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium">Help</span>
                    </a>
                </nav>
            </div>

            <!-- User Profile -->
            <div class="absolute bottom-6 left-6 right-6">
                <div class="flex items-center justify-between">
                    <a href="{{ route('landlord.profile.show') }}" class="flex items-center">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <span class="text-gray-700 font-semibold text-sm block">{{ Auth::user()->name }}</span>
                            <span class="text-gray-500 text-xs capitalize">{{ Auth::user()->user_type }}</span>
                        </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="bg-white border-b border-gray-200 px-6 py-4" style="background-color: #eae9e3;">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-regular text-gray-900">Hello, {{ Auth::check() ? Auth::user()->name : 'Guest' }}!</h1>
                        <p class="text-gray-500 text-xs mt-1">Explore information and activity about your property</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search Anything..." class="w-80 pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>




            <div class="relative">
                <button id="notification-button" class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-200 relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                    @endif
                </button>
                <!-- Notification Dropdown -->
                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($notifications as $notification)
                            <a href="{{ $notification->link ?? '#' }}" class="block p-4 border-b border-gray-100 hover:bg-gray-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full {{ $notification->type_class }} flex items-center justify-center">
                                            {!! $notification->icon !!}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $notification->message }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <p class="mt-2">No notifications</p>
                            </div>
                        @endforelse
                    </div>
                    @if($notifications->count() > 0)
                        <div class="p-2 border-t border-gray-200 text-center">
                            <a href="{{ route('notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all notifications</a>
                        </div>
                    @endif
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const notificationButton = document.getElementById('notification-button');
                    const notificationDropdown = document.getElementById('notification-dropdown');
                    
                    notificationButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        notificationDropdown.classList.toggle('hidden');
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
                            notificationDropdown.classList.add('hidden');
                        }
                    });
                });
            </script>




                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6" style="background-color: #eae9e3;">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>