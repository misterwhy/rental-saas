# 🏠 House Rental Laravel Project

A complete Laravel application for house rental management with landlord and tenant functionality.

## 🚀 How to Run This Project

### Step 1: Install Prerequisites

#### 1. Install PHP 8.2+
1. Download from: **https://windows.php.net/download/**
2. Choose **PHP 8.2+** (Thread Safe version)
3. Extract to `C:\php`
4. Add `C:\php` to your system PATH:
   - Press `Win + R`, type `sysdm.cpl`
   - Go to **Advanced** → **Environment Variables**
   - Edit **PATH** and add `C:\php`

#### 2. Install Composer
1. Download: **https://getcomposer.org/Composer-Setup.exe**
2. Run the installer

#### 3. Verify Installation
```powershell
php --version
composer --version
node --version  # Already installed ✓
```

### Step 2: Quick Setup (Choose One)

#### Option A: Run Setup Script (Easiest)
```powershell
.\setup.ps1
```

#### Option B: Manual Commands
```powershell
# Install dependencies
composer install
npm install

# Set up database  
php artisan migrate

# Build assets
npm run build

# Create storage link
php artisan storage:link
```

### Step 3: Run the Application
```powershell
php artisan serve
```

**Visit: http://localhost:8000**

## ✅ What's Already Configured

Your project is ready with:
- ✅ **Environment (.env)** - All settings configured
- ✅ **SQLite Database** - Ready to use
- ✅ **User Authentication** - Login/Register system
- ✅ **Property Management** - CRUD operations
- ✅ **Payment Integration** - Stripe (test mode)
- ✅ **Image Upload** - Property photos
- ✅ **Responsive Design** - Tailwind CSS

## 🎯 Project Features

- **Landlord Dashboard** - Manage properties, bookings, payments
- **Tenant Portal** - Browse properties, make bookings
- **Property Listings** - Search and filter properties
- **Booking System** - Calendar-based booking
- **Payment Processing** - Secure payments via Stripe
- **Review System** - Property ratings and reviews

## 🔧 Development Commands

```powershell
# Start development server
php artisan serve

# Watch frontend changes
npm run dev

# Clear caches
php artisan cache:clear

# Run migrations
php artisan migrate

# Build for production
npm run build
```

## 🛠️ Troubleshooting

**"php command not found"**
- Install PHP and add to PATH (see Step 1)

**Database errors**
- Run: `php artisan migrate`

**Assets not loading**
- Run: `npm run build`

**Need fresh start**
```powershell
php artisan migrate:fresh
npm run build
```

---

🚀 **Ready to go!** After installing PHP and Composer, just run `.\setup.ps1` and then `php artisan serve`

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
