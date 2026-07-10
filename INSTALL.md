# 🔮 Spell Enchantment — Laravel Installation Guide

A cinematic dark-fantasy occult marketplace built with PHP Laravel, now with a full
admin operations console: Orders, Analytics, Coupons, multi-gateway Payments
(Stripe + PayPal + Manual), digital file delivery, and an Audit Log.

---

## Requirements

| Requirement | Version |
|---|---|
| PHP | 8.2+ (with `ext-curl`, `ext-mbstring`, `ext-openssl`) |
| Composer | 2.x |
| MySQL | 8.0+ (or MariaDB 10.6+) — or SQLite for quick local testing |
| Web Server | Apache or Nginx (or `php artisan serve` for local) |

---

## Quick Install (6 steps)

### Step 1 — Unzip

```bash
unzip spell-enchantment-laravel.zip
cd spell-enchantment-laravel
```

### Step 2 — Install PHP dependencies

```bash
composer install --optimize-autoloader --no-dev
```

> Requires Composer: https://getcomposer.org

### Step 3 — Configure your environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and edit the database section:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spell_enchantment
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

> **Create the database first:**
> ```sql
> CREATE DATABASE spell_enchantment CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> ```

### Step 4 — Run migrations and seed data

```bash
php artisan migrate --seed
```

This creates all tables (products, orders, coupons, downloads, audit logs,
payment settings) and seeds:
- 10 categories, 11+ products (including 2 digital products with real
  attached files for the download-delivery system)
- 3 blog posts, 4 library entries, 6 testimonials

### Step 5 — Link storage & set permissions

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### Step 6 — Start the server

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser. 🎉

---

## Creating your Admin account

The seeder does not create an admin user (for security). Create one via Tinker:

```bash
php artisan tinker
```
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'you@yourdomain.com',
    'password' => bcrypt('choose-a-strong-password'),
    'role' => 'admin',
    'status' => 'active',
]);
```

Then log in at `/login` and visit `/admin` for the dashboard.

---

## Configuring Payment Gateways

All gateway credentials are stored in the database and configured entirely
from **Admin → Payments** (`/admin/payments`) — no `.env` editing required.

- **Stripe** — enter your Secret Key and (optionally) Publishable Key + Webhook
  Signing Secret.
- **PayPal** — enter your Client ID and Client Secret, and choose
  Sandbox or Live mode.
- **Manual** (bank transfer / crypto / pay-on-pickup) — no keys needed, just
  write the instructions customers will see at checkout and on their order page.

Each gateway can be independently enabled/disabled from the same screen.

### Stripe webhook

Point your Stripe webhook to:
```
https://yourdomain.com/webhooks/stripe
```
Subscribe to the `checkout.session.completed` and `payment_intent.succeeded`
events. This is what triggers automatic order fulfillment + digital delivery.

### PayPal return URL

PayPal redirects back to `https://yourdomain.com/checkout/paypal/return`
automatically — no extra dashboard config needed beyond your Client ID/Secret.

### Manual payment

For bank transfer, crypto, or "pay on pickup" style orders — customers see the
instructions you set in Admin → Payments, and orders stay in a "pending
payment" state until you mark them paid in Admin → Orders.

---

## Digital Product Delivery

Products with `type = digital` can have a file attached in **Admin → Shop →
Edit Product** (upload field). Once an order is marked **paid**, the customer
gets a secure, tokenized download link (visible on their order page and, if
mail is configured, emailed to them). Download tokens can be revoked/reissued
from **Admin → Orders**.

---

## SQLite Quick Start (no MySQL required)

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/spell-enchantment-laravel/database/database.sqlite
```

```bash
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

---

## Production Deployment (Apache/Nginx)

### Apache

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/spell-enchantment-laravel/public

    <Directory /var/www/spell-enchantment-laravel/public>
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
    root /var/www/spell-enchantment-laravel/public;

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

# Storage link + permissions
php artisan storage:link
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Remember to also set your live Stripe/PayPal keys and switch `PAYPAL_MODE=live`
before accepting real payments, and point the Stripe webhook at your real
domain (see above).

---

## Directory Structure (key additions)

```
spell-enchantment-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── OrderController.php
│   │   │   ├── CouponController.php
│   │   │   ├── PaymentSettingsController.php
│   │   │   ├── AnalyticsController.php
│   │   │   ├── AuditLogController.php
│   │   │   └── ShopController.php
│   │   ├── CheckoutController.php        ← coupon apply, gateway dispatch
│   │   ├── StripeWebhookController.php
│   │   └── OrderController.php           ← secure download route
│   ├── Services/
│   │   ├── PaymentService.php
│   │   ├── DigitalDeliveryService.php
│   │   └── PaymentGateways/
│   │       ├── PaymentGatewayInterface.php
│   │       ├── StripeGateway.php
│   │       ├── PaypalGateway.php
│   │       └── ManualGateway.php
│   └── Models/
│       ├── Coupon.php
│       ├── Download.php
│       ├── AuditLog.php
│       ├── PaymentSetting.php
│       └── Setting.php
├── resources/views/admin/
│   ├── orders/ (index, show)
│   ├── coupons/index
│   ├── payments/index
│   ├── analytics/index
│   └── audit-logs/index
├── database/migrations/                  ← all table definitions
├── database/seeders/DatabaseSeeder.php   ← all seed data incl. digital files
└── INSTALL.md                            ← this file
```

---

## Admin Panel Pages

| URL | Description |
|---|---|
| `/admin` | Dashboard — key metrics overview |
| `/admin/shop` | Product management (physical + digital, file upload, stock) |
| `/admin/orders` | Orders list & detail — status pipeline, manual payment marking |
| `/admin/coupons` | Discount coupon management |
| `/admin/payments` | Stripe / PayPal / Manual gateway configuration |
| `/admin/analytics` | Revenue, best sellers, digital vs physical split |
| `/admin/audit-logs` | Who changed what, and when |

## Storefront Pages

| URL | Description |
|---|---|
| `/` | Home |
| `/shop` , `/shop/{slug}` | Product grid & detail |
| `/library` , `/library/{slug}` | Free arcane library content |
| `/blog` , `/blog/{slug}` | The Scholar's Chronicles |
| `/cart` | Session-based cart |
| `/checkout` | Coupon code, payment method selection (Stripe/PayPal/Manual) |
| `/orders/{id}` | Order confirmation, download links, manual payment instructions |
| `/downloads/{token}` | Secure, tokenized digital file download |

---

## Customisation

### Change the colour palette
Edit CSS variables in `public/css/arcane.css` (storefront) and
`public/css/admin.css` (admin panel).

### Add more products/categories
Use Admin → Shop, or add rows to `DatabaseSeeder.php` and re-seed:
```bash
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
| Uploaded product files 404 | Run `php artisan storage:link` |
| Stripe webhook not firing | Check webhook URL, secret, and that `webhooks/stripe` is CSRF-exempt (already configured in `bootstrap/app.php`) |
| Composer not found | Install from https://getcomposer.org |

---

*Built by Spell Enchantment — Ancient Knowledge · Mystical Arts*
