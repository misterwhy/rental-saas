<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'House Rental') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

    <style>
        /* CSS Variables for easy theming */
        :root {
            --color-primary: #4f46e5;
            --color-primary-dark: #4338ca;
            --color-text-heading: #111827;
            --color-text-body: #374151;
            --color-text-muted: #6b7280;
            --color-bg-light: #f9fafb;
            --color-bg-dark: #111827;
            --color-white: #ffffff;
            --color-border: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --border-radius: 0.5rem;
            --transition-speed: 0.2s;
        }

        /* Base & Reset */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: var(--color-bg-light);
            color: var(--color-text-body);
        }
        main {
            display: block;
        }
        a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color var(--transition-speed) ease-in-out;
        }
        a:hover {
            color: var(--color-primary-dark);
        }

        /* Container */
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding: 0 1.5rem;
        }
        @media (min-width: 640px) { .container { max-width: 640px; } }
        @media (min-width: 768px) { .container { max-width: 768px; } }
        @media (min-width: 1024px) { .container { max-width: 1024px; } }
        @media (min-width: 1280px) { .container { max-width: 1280px; } }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background-color: var(--color-white);
            border-bottom: 1px solid var(--color-border);
            box-shadow: var(--shadow-sm);
        }
        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--color-primary);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .nav-links a {
            font-weight: 500;
            color: var(--color-text-body);
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--color-primary);
            transform-origin: bottom right;
            transition: transform var(--transition-speed) ease-out;
        }
        .nav-links a:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        .nav-links a:hover {
            color: var(--color-primary);
        }

        /* Hero Section */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh; /* Increased height for better centering */
            text-align: center;
            padding: 3rem 1.5rem; /* Adjusted padding */
            background-image: linear-gradient(145deg, #eef2ff 0%, #fbfaff 100%);
        }
        .hero-content {
            max-width: 800px; /* Added wrapper for content */
            width: 100%;
        }
        .hero h1 {
            font-size: 3rem; /* Slightly reduced font size */
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: var(--color-text-heading);
        }
        .hero p {
            font-size: 1.25rem;
            color: var(--color-text-muted);
            max-width: 60ch;
            margin: 0 auto 2.5rem auto; /* Center the paragraph */
            line-height: 1.6;
        }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.875rem 2rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all var(--transition-speed) ease-in-out;
            text-align: center;
            border: 1px solid transparent;
        }
        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
            box-shadow: var(--shadow-md);
        }
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
            color: var(--color-white);
        }
        .btn-secondary {
            background-color: var(--color-white);
            color: var(--color-primary);
            border-color: var(--color-border);
            box-shadow: var(--shadow-sm);
        }
        .btn-secondary:hover {
            border-color: var(--color-primary);
            background-color: #f0f1ff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        /* Features Section */
        .features {
            padding: 6rem 1rem;
            background-color: var(--color-white);
        }
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--color-text-heading);
            margin-bottom: 1rem;
        }
        .section-subtitle {
            text-align: center;
            font-size: 1.25rem;
            color: var(--color-text-muted);
            max-width: 60ch;
            margin: 0 auto 4rem auto;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            padding: 2rem;
            border-radius: var(--border-radius);
            background-color: var(--color-bg-light);
            border: 1px solid var(--color-border);
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }
        .feature-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            border-radius: 0.75rem;
            background-color: #eef2ff;
            color: var(--color-primary);
        }
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--color-text-heading);
            margin: 0 0 0.5rem 0;
        }
        .feature-card p {
            color: var(--color-text-muted);
            line-height: 1.6;
            margin: 0;
        }
        
        /* Footer */
        .footer {
            background-color: var(--color-bg-dark);
            color: #9ca3af;
            padding: 4rem 1rem;
            text-align: center;
        }
        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        .footer a {
            color: var(--color-white);
            font-weight: 500;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .section-title { font-size: 2.25rem; }
        }
        @media (max-width: 640px) {
            .cta-buttons {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
                max-width: 320px;
                margin: 0 auto;
            }
            .hero h1 { font-size: 2rem; }
            .hero { 
                padding: 2rem 1rem; 
                min-height: 70vh;
            }
            .features { padding: 4rem 1.5rem; }
            .header { padding: 1rem 1.5rem; }
            .logo { font-size: 1.25rem; }
            .nav-links { gap: 1rem; }
        }
    </style>
</head>
<body class="antialiased">
    <header class="header">
        <div class="logo">{{ config('app.name', 'House Rental') }}</div>
        <nav class="nav-links">
        @auth
            @if(Auth::user()->role === 'landlord')
                <a href="{{ route('landlord.dashboard') }}">Dashboard</a>
                <a href="{{ route('landlord.properties.index') }}">My Properties</a>
                <a href="{{ route('landlord.rent-payments.index') }}">Rent Payments</a>
                <a href="{{ route('landlord.profile.show') }}">Profile</a>
            @else
                <a href="{{ route('tenant.dashboard') }}">Dashboard</a>
                <a href="{{ route('tenant.properties.index') }}">My Property</a>
                <a href="{{ route('tenant.rent-payments.index') }}">My Payments</a>
                <a href="{{ route('tenant.profile.show') }}">Profile</a>
            @endif
            
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                    <h1>Find and Manage Your Perfect Rental Home</h1>
                    <p>Efficiently manage your properties, tenants, leases, and payments in one centralized platform designed for clarity and ease of use.</p>
                    <div class="cta-buttons">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started for Free</a>
                            <a href="{{ route('login') }}" class="btn btn-secondary">Login to Account</a>
                        @endauth
                    </div>

            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2 class="section-title">Everything You Need</h2>
                <p class="section-subtitle">A comprehensive suite of tools to streamline your rental business, from listing to financial reporting.</p>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">🏠</div>
                        <h3>Property Management</h3>
                        <p>Add, edit, and organize all your rental properties with detailed information and beautiful photo galleries.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">👥</div>
                        <h3>Tenant Management</h3>
                        <p>Maintain complete tenant records, important documents, and a full communication history in one secure place.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">📝</div>
                        <h3>Lease Agreements</h3>
                        <p>Create and manage lease agreements with digital signatures, automated renewals, and deadline tracking.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon-wrapper">💳</div>
                        <h3>Payment Tracking</h3>
                        <p>Monitor rent payments, automate late fees, and generate insightful financial reports with just a few clicks.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'House Rental') }}. Built with ❤️ for property managers. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>