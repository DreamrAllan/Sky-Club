# Sky Club - Mini Soccer Booking

Website booking lapangan mini soccer.

## Requirements
- PHP 8.2+
- Composer
- Node.js 18+
- SQLite/MySQL/PostgreSQL

## Local Development

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
touch database/database.sqlite
php artisan migrate --seed
php artisan db:seed --class=ContentSeeder
php artisan db:seed --class=PhotoSeeder

# Create storage link
php artisan storage:link

# Build assets
npm run build

# Run server
php artisan serve
```

## Deploy to Railway

1. Create account at [railway.app](https://railway.app)
2. Create new project → Deploy from GitHub repo
3. Add environment variables:
   - `APP_KEY` (run `php artisan key:generate --show`)
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `DB_CONNECTION=sqlite`
4. Railway will auto-detect PHP and deploy

## Deploy to Render

1. Create account at [render.com](https://render.com)
2. Create new Web Service → Connect GitHub repo
3. Settings:
   - Runtime: PHP
   - Build Command: `composer install --no-dev && npm install && npm run build`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

## Features
- Field booking with calendar
- Sparing (match) scheduling
- User reviews & testimonials  
- Articles/Blog
- Admin dashboard
