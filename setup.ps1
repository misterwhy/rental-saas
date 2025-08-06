# Laravel House Rental Project Setup Script
# Run this script after installing PHP and Composer

Write-Host "=== Laravel House Rental Setup ===" -ForegroundColor Green

# Check if PHP is installed
try {
    $phpVersion = php --version
    Write-Host "✓ PHP is installed: $($phpVersion.Split("`n")[0])" -ForegroundColor Green
} catch {
    Write-Host "✗ PHP is not installed. Please install PHP first." -ForegroundColor Red
    Write-Host "Download from: https://windows.php.net/download/" -ForegroundColor Yellow
    exit 1
}

# Check if Composer is installed
try {
    $composerVersion = composer --version
    Write-Host "✓ Composer is installed: $($composerVersion.Split("`n")[0])" -ForegroundColor Green
} catch {
    Write-Host "✗ Composer is not installed. Please install Composer first." -ForegroundColor Red
    Write-Host "Download from: https://getcomposer.org/download/" -ForegroundColor Yellow
    exit 1
}

# Install PHP dependencies
Write-Host "`n1. Installing PHP dependencies..." -ForegroundColor Cyan
composer install

# Install Node.js dependencies
Write-Host "`n2. Installing Node.js dependencies..." -ForegroundColor Cyan
npm install

# Create SQLite database if it doesn't exist
Write-Host "`n3. Setting up database..." -ForegroundColor Cyan
if (!(Test-Path "database/database.sqlite")) {
    New-Item -Path "database/database.sqlite" -ItemType File
    Write-Host "✓ Created SQLite database file" -ForegroundColor Green
} else {
    Write-Host "✓ SQLite database file already exists" -ForegroundColor Green
}

# Run database migrations
Write-Host "`n4. Running database migrations..." -ForegroundColor Cyan
php artisan migrate --force

# Generate application key if needed
Write-Host "`n5. Checking application key..." -ForegroundColor Cyan
if ($env:APP_KEY -eq $null -or $env:APP_KEY -eq "") {
    php artisan key:generate
    Write-Host "✓ Generated new application key" -ForegroundColor Green
} else {
    Write-Host "✓ Application key already exists" -ForegroundColor Green
}

# Create storage symlink
Write-Host "`n6. Creating storage symlink..." -ForegroundColor Cyan
php artisan storage:link

# Build frontend assets
Write-Host "`n7. Building frontend assets..." -ForegroundColor Cyan
npm run build

Write-Host "`n=== Setup Complete! ===" -ForegroundColor Green
Write-Host "`nTo start the development server, run:" -ForegroundColor Yellow
Write-Host "php artisan serve" -ForegroundColor White
Write-Host "`nThe application will be available at: http://localhost:8000" -ForegroundColor Yellow
