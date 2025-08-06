@echo off
echo === Laravel House Rental Setup ===

REM Check if PHP is installed
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: PHP is not installed or not in PATH
    echo Download from: https://windows.php.net/download/
    pause
    exit /b 1
)

REM Check if Composer is installed
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Error: Composer is not installed or not in PATH
    echo Download from: https://getcomposer.org/download/
    pause
    exit /b 1
)

echo 1. Installing PHP dependencies...
composer install

echo 2. Installing Node.js dependencies...
npm install

echo 3. Setting up database...
if not exist "database\database.sqlite" (
    type nul > "database\database.sqlite"
    echo Created SQLite database file
)

echo 4. Running database migrations...
php artisan migrate --force

echo 5. Creating storage symlink...
php artisan storage:link

echo 6. Building frontend assets...
npm run build

echo.
echo === Setup Complete! ===
echo.
echo To start the development server, run:
echo php artisan serve
echo.
echo The application will be available at: http://localhost:8000
pause
