# Arcane Sanctum (Spell Enchantment)

A Laravel storefront selling occult/witchcraft products — physical (kits, crystals, candles, amulets) and digital
(grimoires, guides), plus a blog and free "Library" content. Includes an admin panel (dashboard, products, users,
coupons, payments, support chat, audit log).

## Stack
- Laravel 12, PHP 8.2, SQLite (`database/database.sqlite`)
- Tailwind v4 + Vite for the small amount of admin CSS tooling; the storefront itself uses a static
  `public/css/arcane.css` (not part of the Vite pipeline).
- Document root is `public/` (renamed from the original `public_html/` used for shared hosting).

## Running it
- Workflow **Start application** runs `npm run start`, which serves the app via PHP's built-in server on port 5000
  through `public/router.php` (a small router so static assets under `public/` are served directly and everything
  else falls through to Laravel's `index.php` — the built-in server needs this because it doesn't do that check
  itself).
- Admin CSS/JS are pre-built into `public/build` via `npm run build` (Vite). Re-run that after editing
  `resources/css/app.css` or `resources/js/app.js`.
- Seed data: `php artisan migrate --seed` (categories, products, blog posts, library entries, testimonials).
- Admin login: `admin@spellenchantment.com` / `AdminPass123!` (seeded manually, not part of `DatabaseSeeder`).

## Key features
- **Orders ↔ Users sync**: `CheckoutController@store` finds-or-creates a `User` (role `customer`) for every
  checkout email, even for guest checkout, and links `orders.user_id`. This is what makes every order show up
  under Admin > Users.
- **Support tickets**: `Ticket` / `TicketMessage` models. Customers reach support two ways: from their order
  confirmation page (`/orders/{order}/support`, no login required — same access model as the order page itself),
  or via `/support` if logged in. Admin replies from `/admin/chat`. Ticket status flow: `open` → `waiting_admin`
  (customer sent a message) → `replied` (admin replied) → `closed`.
  Dashboard and the chat inbox both show ticket counts by status.
- **Audit log**: `AuditLog::record()` is called from checkout (order placed/payment failed), login/logout/register,
  coupon apply, ticket messages (customer + admin), and admin CRUD on users/products, in addition to the existing
  order-status-change logging. View at `/admin/audit-logs`.

## User preferences
(none recorded yet)
