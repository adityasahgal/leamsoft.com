# Leamsoft Pvt Ltd. — Website & Admin Panel

A Laravel 11 application powering the public Leamsoft website (AI / Cloud / Blockchain / SaaS marketing site) plus a full admin panel for managing settings, banners, categories, subcategories, services, blogs, gallery, enquiries, users, and roles/permissions.

## Stack

- **PHP** 8.2+
- **Laravel** 11
- **MySQL** 5.7+ / MariaDB 10.3+
- **Node.js** 18+ (for Vite frontend build)
- **Spatie Permission** for role-based access control
- **maatwebsite/excel** for exports
- **Spatie Sitemap** for generating sitemap.xml
- **AdminLTE** + Bootstrap 5 in admin
- Custom Tailwind-flavoured CSS theme on the frontend (Bebas Neue / Barlow via Google Fonts, animated rainbow gradients)

## Prerequisites

Make sure these are installed locally:

- PHP 8.2 with `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, `gd` extensions
- Composer 2.x
- Node.js 18+ and npm
- MySQL 5.7+ or MariaDB 10.3+
- A running web server (Apache / Nginx) or `php artisan serve` for development

## Quick Setup

```bash
# 1. Clone
git clone <repo-url> leamsoft
cd leamsoft

# 2. Install PHP & JS dependencies
composer install
npm install

# 3. Environment file
cp .env.example .env
php artisan key:generate
```

## Configure `.env`

Open `.env` and set the database + app values. Minimum required:

```env
APP_NAME="Leamsoft"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=leamsoft
DB_USERNAME=root
DB_PASSWORD=

# Required by the enquiry form on /contact-us
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=

# Mail (optional, for enquiry notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@leamsoft.in"
MAIL_FROM_NAME="${APP_NAME}"
```

> Note: `.env.example` ships with `DB_CONNECTION=sqlite`. Change it to `mysql` (or your DB of choice) before running migrations.

Create the database in MySQL:

```sql
CREATE DATABASE leamsoft CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Database

```bash
# Run migrations
php artisan migrate

# Seed initial data:
#   - CategorySeeder         → seeds the 6 marketing categories used on the frontend
#   - SuperAdminSeeder       → creates all permissions + the Super Admin / CEO roles,
#                              and grants both roles + all permissions to the canonical
#                              super admin user (see database/seeders/SuperAdminSeeder.php
#                              to edit the $superAdminEmails list)
php artisan db:seed
```

### Storage symlink

Uploaded logos, favicons, banners, category/gallery images, etc. live under `storage/app/public/`. To make them web-accessible:

```bash
php artisan storage:link
```

## Build Frontend Assets

```bash
# Development (with HMR)
npm run dev

# Production build
npm run build
```

## Run the App

```bash
php artisan serve
```

- Public site: <http://localhost:8000/>
- Admin login: <http://localhost:8000/admin/login>

Sign in with the super admin email configured in `database/seeders/SuperAdminSeeder.php`. If that user doesn't exist yet, the seeder will create them with password `password` — change it immediately via Admin → Users → Change Password.

## Admin Panel Modules

Once logged in as Super Admin you'll see:

| Module | Purpose |
| --- | --- |
| **Dashboard** | Overview landing page |
| **Banners** | Hero carousel banners (homepage) |
| **Categories** | Top-level service categories (AI, Blockchain, etc.) |
| **Subcategories** | Child categories under a parent |
| **Gallery** | Showcase photos for the `/gallery` page |
| **Blogs** | Blog posts (frontend `/blog`) |
| **Enquiry** | Submissions from the contact form |
| **Settings → General** | Site name, logo, favicon, address, phone, email, all social URLs, description (used in footer) |
| **Administrators → Roles / Permission / Users** | Spatie role/permission management |

Everything the frontend renders — the navbar logo, footer logo, contact details, social links, hero banner carousel, services, blogs — reads from these modules dynamically. Update Settings to instantly rebrand the site.

## Frontend Routes

| URL | Purpose |
| --- | --- |
| `/` | Home (hero, services preview, industries, CTA) |
| `/about-us` | Company intro, mission, vision, core values, tech stack, dev process |
| `/services` (or `/villas`) | Service catalogue, grouped by category |
| `/blog` | Latest blog posts |
| `/blog/{slug}` | Single blog post |
| `/gallery` | Photo gallery |
| `/faq` | FAQ page |
| `/help` | Help center |
| `/contact-us` | Contact form (reCAPTCHA-protected) |
| `/privacy-policy`, `/terms-condition` | Legal pages |
| `/{slug}` | Resolves dynamically to a category, subcategory, or service |

## Useful Commands

```bash
# Regenerate sitemap.xml at /sitemap.xml
php artisan tinker --execute="\App\Http\Controllers\Admin\DashboardController::class"  # see DashboardController@generate

# Clear caches after .env or config changes
php artisan optimize:clear

# Re-seed only the super admin (idempotent)
php artisan db:seed --class=SuperAdminSeeder

# List all routes (handy for debugging)
php artisan route:list
```

## Troubleshooting

**"Symbol DB undefined" / Intelephense errors**
False positives from the static analyzer on Blade `@can` / `@canany` blocks — they don't affect runtime.

**Uploaded images don't show**
Make sure you ran `php artisan storage:link` and that `public/storage` symlink exists.

**Can't access admin modules even as the seeded user**
Log out and log back in so Spatie's role cache picks up the new permissions. If still blocked: `php artisan cache:clear`.

**reCAPTCHA verification failed on contact form**
Set valid `RECAPTCHA_SITE_KEY` / `RECAPTCHA_SECRET_KEY` in `.env`, or comment out the recaptcha rule in `MainController@enquiry` for local testing.

**Gallery / category images returning 404 in storage**
Re-create the symlink: `rm public/storage && php artisan storage:link`.

## Project Structure (quick reference)

```
app/
  Http/Controllers/
    Admin/                  # All admin CRUD controllers
    MainController.php      # Frontend routes
    HomeController.php
  Models/                   # Eloquent models (Setting, Banner, Category, ...)
  Providers/AppServiceProvider.php   # Gate::before — Super Admin bypasses all permission checks

database/
  migrations/               # Schema (categories, subcategories, gallery, etc.)
  seeders/
    CategorySeeder.php
    SuperAdminSeeder.php    # Edit $superAdminEmails to set the canonical admin

resources/views/
  layouts/
    master.blade.php        # Frontend layout shell (loads dynamic settings)
    frontendHeader.blade.php
    frontendFooter.blade.php
    admin.blade.php         # Admin layout shell
    navigation.blade.php    # Admin sidebar menu
  frontend/                 # Public pages
  admin/                    # Admin module views
  components/application-logo.blade.php   # Admin sidebar brand logo

routes/web.php              # All routes (public + admin)
```

## License

Internal proprietary code — © Leamsoft Pvt Ltd. All rights reserved.
