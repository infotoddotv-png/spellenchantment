# 🔮 Arcane Sanctum — Laravel Installation Guide

A cinematic dark-fantasy marketplace built with PHP Laravel.  
Dark purple-black aesthetic inspired by Hogwarts + Elden Ring.

---

## Requirements

| Requirement | Version |
|---|---|
| PHP | 8.2+ |
| Composer | 2.x |
| MySQL | 8.0+ (or MariaDB 10.6+) |
| Web Server | Apache or Nginx (or `php artisan serve` for local) |

---

## Quick Install (5 steps)

### Step 1 — Unzip

```bash
unzip arcane-sanctum-laravel.zip
cd arcane-sanctum-laravel
```

### Step 2 — Install PHP dependencies

```bash
composer install --optimize-autoloader
```

> This requires Composer on your system. Download at https://getcomposer.org

### Step 3 — Configure your environment

```bash
cp .env.example .env
php artisan key:generate
```

Now open `.env` and edit the database section:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arcane_sanctum   # create this database first
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

> **Create the database first:**
> ```sql
> CREATE DATABASE arcane_sanctum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> ```

### Step 4 — Run migrations and seed data

```bash
php artisan migrate --seed
```

This creates all tables and populates them with:
- 10 categories (7 shop + 3 library)
- 11 products (wands, grimoires, crystals, tarot, runes, amulets, candles)
- 3 blog posts
- 4 library entries
- 6 testimonials

### Step 5 — Start the server

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser. 🎉

---

## SQLite Quick Start (no MySQL required)

For local testing without MySQL, edit `.env`:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/arcane-sanctum-laravel/database/database.sqlite
```

Then:
```bash
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

---

## Production Deployment (Apache/Nginx)

### Apache

Point your virtual host document root to the `/public` directory:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/arcane-sanctum-laravel/public

    <Directory /var/www/arcane-sanctum-laravel/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Enable mod_rewrite: `sudo a2enmod rewrite && sudo service apache2 restart`

### Nginx

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/arcane-sanctum-laravel/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Production checklist

```bash
# Set production mode
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

# Set your domain
sed -i 's|APP_URL=http://localhost:8000|APP_URL=https://yourdomain.com|' .env

# Optimise
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## Directory Structure

```
arcane-sanctum-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── ShopController.php
│   │   ├── LibraryController.php
│   │   ├── BlogController.php
│   │   ├── CartController.php        ← session-based cart
│   │   ├── CheckoutController.php
│   │   └── OrderController.php
│   └── Models/
│       ├── Category.php
│       ├── Product.php
│       ├── BlogPost.php
│       ├── LibraryEntry.php
│       ├── Order.php
│       └── Testimonial.php
├── database/
│   ├── migrations/                   ← all table definitions
│   ├── seeders/DatabaseSeeder.php    ← all seed data
│   └── arcane_sanctum_mysql_schema.sql ← raw SQL if needed
├── public/
│   ├── css/arcane.css                ← full dark-fantasy stylesheet
│   ├── js/arcane.js                  ← particles, cursor, interactions
│   └── images/hero-bg.jpg           ← hero background image
├── resources/views/
│   ├── layouts/app.blade.php         ← navbar, footer, magic cursor
│   └── pages/
│       ├── home.blade.php
│       ├── shop/index.blade.php
│       ├── shop/show.blade.php
│       ├── library/index.blade.php
│       ├── library/show.blade.php
│       ├── blog/index.blade.php
│       ├── blog/show.blade.php
│       ├── cart.blade.php
│       ├── checkout.blade.php
│       └── orders/show.blade.php
├── routes/web.php                    ← all routes
├── .env.example                      ← template config
├── composer.json
└── INSTALL.md                        ← this file
```

---

## Pages & URLs

| URL | Description |
|---|---|
| `/` | Home — hero, featured products, library preview, stats, testimonials |
| `/shop` | Product grid with category sidebar filter |
| `/shop/{slug}` | Individual product detail with lore and add-to-cart |
| `/library` | Arcane library with difficulty filtering by category tab |
| `/library/{slug}` | Individual library entry |
| `/blog` | The Scholar's Chronicles with featured post layout |
| `/blog/{slug}` | Individual blog post |
| `/cart` | Your Satchel (session-based cart) |
| `/checkout` | Order form with payment method selection |
| `/orders/{id}` | Order confirmation |

---

## Features

- **Dark-fantasy design** — `#0a0608` background, gold `#c9a84c` primary, purple accent, glass-card panels
- **Cinzel display font** + **Crimson Pro** body serif, loaded from Google Fonts
- **Particle canvas background** — 80 animated particles with mouse repulsion
- **Magic cursor** — gold ring following the mouse (desktop only)
- **Scroll fade-in** animations on all content blocks
- **Responsive navbar** — transparent → frosted glass on scroll, mobile hamburger menu
- **Category filter** — shop sidebar and library tabs (no JavaScript fetch — server-side filtering)
- **Session cart** — add / update / remove items with quantity controls
- **Checkout** — validates name, email, payment method; saves order to database
- **Order confirmation** — full order manifest with itemised total

---

## Customisation

### Add a product image
Put the image in `public/images/` and set the `image_url` column to `/images/filename.jpg`.

### Change the colour palette
Edit the CSS variables at the top of `public/css/arcane.css`:

```css
:root {
  --primary: hsl(44, 56%, 54%);   /* gold */
  --accent:  hsl(270, 80%, 50%);  /* purple */
  --background: hsl(330, 25%, 3%); /* near-black */
}
```

### Add more products/categories
Use Laravel Tinker or add rows to `DatabaseSeeder.php` and re-seed:

```bash
php artisan tinker
# or
php artisan migrate:fresh --seed   # WARNING: drops all data
```

---

## Troubleshooting

| Problem | Solution |
|---|---|
| Blank page / 500 error | Check `storage/logs/laravel.log` |
| "Permission denied" | `chmod -R 775 storage bootstrap/cache` |
| "No application encryption key" | `php artisan key:generate` |
| CSS/JS not loading | Ensure DocumentRoot points to `/public`, not project root |
| Database error | Verify `.env` credentials and that the database exists |
| Composer not found | Install from https://getcomposer.org |

---

*Built by Arcane Sanctum — Ancient Knowledge · Mystical Arts*
