<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'House Rental') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
        }
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc; /* slate-50 */
            color: #1e293b; /* slate-800 */
        }
        a {
            background-color: transparent;
            color: #4f46e5; /* indigo-600 */
            text-decoration: none;
        }
        a:hover {
            color: #4338ca; /* indigo-700 */
            text-decoration: underline;
        }
        b, strong {
            font-weight: bolder;
        }
        h1, h2, h3, h4, h5, h6 {
            font-size: inherit;
            font-weight: inherit;
        }
        button, input, optgroup, select, textarea {
            font-family: inherit;
            font-size: 100%;
            line-height: 1.15;
            margin: 0;
            padding: 0;
            border: 1px solid #cbd5e1; /* slate-300 */
            border-radius: 0.375rem; /* rounded-md */
        }
        button, input:is([type='button'], [type='reset'], [type='submit']) {
            appearance: button;
        }
        button {
            background-color: #f1f5f9; /* slate-100 */
            padding: 0.5rem 1rem;
            font-weight: 500;
            cursor: pointer;
        }
        button:hover {
            background-color: #e2e8f0; /* slate-200 */
        }
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding: 1rem;
        }
        @media (min-width: 640px) {
            .container {
                max-width: 640px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 768px;
            }
        }
        @media (min-width: 1024px) {
            .container {
                max-width: 1024px;
            }
        }
        @media (min-width: 1280px) {
            .container {
                max-width: 1280px;
            }
        }
        .header {
            display: flex;
            justify-content: flex-end;
            padding: 1rem;
        }
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            text-align: center;
            padding: 2rem;
        }
        .hero h1 {
            font-size: 2.25rem; /* text-4xl */
            font-weight: 700; /* font-bold */
            line-height: 1.1; /* tight */
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.25rem; /* text-xl */
            color: #64748b; /* slate-500 */
            max-width: 36rem;
            margin-bottom: 2rem;
        }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        .btn-primary {
            background-color: #4f46e5; /* indigo-600 */
            color: white;
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 500; /* font-medium */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
        }
        .btn-primary:hover {
            background-color: #4338ca; /* indigo-700 */
            text-decoration: none;
        }
        .btn-secondary {
            background-color: white;
            color: #4f46e5; /* indigo-600 */
            padding: 0.75rem 1.5rem; /* py-3 px-6 */
            border: 1px solid #c7d2fe; /* indigo-200 */
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 500; /* font-medium */
        }
        .btn-secondary:hover {
            background-color: #f1f5f9; /* slate-100 */
            border-color: #a5b4fc; /* indigo-300 */
        }
        .features {
            padding: 4rem 1rem;
            background-color: white;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .feature-card {
            padding: 1.5rem;
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-card h3 {
            font-size: 1.25rem; /* text-xl */
            font-weight: 600; /* font-semibold */
            margin-bottom: 0.5rem;
        }
        .footer {
            background-color: #0f172a; /* slate-900 */
            color: #cbd5e1; /* slate-300 */
            padding: 2rem 1rem;
            text-align: center;
        }
        @media (max-width: 640px) {
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            .btn-primary, .btn-secondary {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav-links">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('properties.index') }}">Properties</a>
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
            <h1>House Rental Management System</h1>
            <p>Efficiently manage your properties, tenants, leases, and payments in one centralized platform.</p>
            <div class="cta-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Login</a>
                @endauth
            </div>
        </section>

        <section class="features">
            <div class="container">
                <h2 style="text-align: center; font-size: 1.875rem; font-weight: 700;">Key Features</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>PropertyParams Management</h3>
                        <p>Add, edit, and organize all your rental properties with detailed information and images.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Tenant Management</h3>
                        <p>Maintain tenant records, background checks, and communication history.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Lease Agreements</h3>
                        <p>Create and manage lease agreements with digital signatures and automated renewals.</p>
                    </div>
                    <div class="feature-card">
                        <h3>Payment Tracking</h3>
                        <p>Monitor rent payments, late fees, and generate financial reports with ease.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'House Rental') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>