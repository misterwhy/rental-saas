# Environment Configuration Guide

## Required Environment Variables

Create a `.env` file in the root directory with the following variables:

```bash
# Application
APP_NAME="House Rental"
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Alternative MySQL Configuration (uncomment if using MySQL)
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=house_rental
# DB_USERNAME=root
# DB_PASSWORD=

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@houserental.com"
MAIL_FROM_NAME="${APP_NAME}"

# Payment Configuration (Stripe)
STRIPE_KEY=pk_test_YOUR_STRIPE_PUBLISHABLE_KEY
STRIPE_SECRET=sk_test_YOUR_STRIPE_SECRET_KEY
STRIPE_WEBHOOK_SECRET=whsec_YOUR_WEBHOOK_SECRET

# File Storage
FILESYSTEM_DISK=local

# Cache
CACHE_DRIVER=file

# Session
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Queue
QUEUE_CONNECTION=sync

# Property Settings
PROPERTY_MAX_IMAGES=10
PROPERTY_MAX_IMAGE_SIZE=5120
PROPERTY_PAGINATION_LIMIT=12
```

## Development Setup

1. Copy the example file:
   ```bash
   cp .env.example .env
   ```

2. Generate application key:
   ```bash
   php artisan key:generate
   ```

3. Create database file (for SQLite):
   ```bash
   touch database/database.sqlite
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. (Optional) Seed with sample data:
   ```bash
   php artisan db:seed --class=DevelopmentSeeder
   ```

## Production Setup

### Security Considerations

1. Set `APP_DEBUG=false`
2. Use secure, random `APP_KEY`
3. Use production database (MySQL/PostgreSQL)
4. Configure proper mail settings
5. Set up SSL certificates
6. Configure proper file permissions

### Required Changes for Production

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use production database
DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-secure-password

# Production mail settings
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls

# Production Stripe keys
STRIPE_KEY=pk_live_YOUR_LIVE_KEY
STRIPE_SECRET=sk_live_YOUR_LIVE_SECRET
```

## Feature Flags

You can enable/disable features using environment variables:

```bash
# Enable image optimization
IMAGE_OPTIMIZATION_ENABLED=true

# Enable caching
CACHE_PROPERTIES=true

# Enable email notifications
EMAIL_NOTIFICATIONS=true

# Enable property approval workflow
PROPERTY_APPROVAL_REQUIRED=false
```
