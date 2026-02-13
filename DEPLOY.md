# SIJSEMSS - cPanel Deployment Guide

## Pre-requisites

- cPanel hosting with **PHP 8.2+** and **MySQL 5.7+**
- The following PHP extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `curl`

---

## Step 1: Prepare Files

### Option A: Upload via File Manager (Recommended)
1. **Zip** the entire project folder on your local machine
2. Login to **cPanel → File Manager**
3. Navigate to `/home/yourusername/` (NOT `public_html` yet)
4. Create a folder called `sijsemss` (or any name)
5. Upload the zip file there and **Extract** it
6. Make sure `composer.json`, `artisan`, `app/`, etc. are directly inside `/home/yourusername/sijsemss/`

### Option B: Upload via FTP
1. Connect using FileZilla or similar FTP client
2. Upload all files to `/home/yourusername/sijsemss/`

> **Important:** Do NOT upload everything into `public_html`. Only the contents of the `public/` folder should be web-accessible.

---

## Step 2: Install Composer Dependencies (if not included)

If you uploaded **without** the `vendor/` folder:

1. Go to **cPanel → Terminal** (or SSH)
2. Run:
   ```bash
   cd ~/sijsemss
   composer install --no-dev --optimize-autoloader
   ```

If your hosting doesn't have Composer:
- Install vendor locally: `composer install --no-dev`
- Upload the `vendor/` folder along with everything else

---

## Step 3: Point Domain to Public Folder

### Option A: Subdomain / Addon Domain (Best)
1. Go to **cPanel → Domains** or **Subdomains**
2. Set the **Document Root** to: `/home/yourusername/sijsemss/public`

### Option B: Main Domain (public_html)
If you must use `public_html`:
1. Move or copy **ONLY** the contents of `public/` into `public_html/`
2. Edit `public_html/index.php` — update the paths:
   ```php
   // Change these lines:
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   
   // To point to your app folder:
   require __DIR__.'/../sijsemss/vendor/autoload.php';
   $app = require_once __DIR__.'/../sijsemss/bootstrap/app.php';
   ```
3. Also copy `install.php` into `public_html/` and update its `$basePath`:
   ```php
   $basePath = dirname(__DIR__) . '/sijsemss';
   ```

---

## Step 4: Create MySQL Database

1. Go to **cPanel → MySQL Databases**
2. Create a new database (e.g., `youruser_sijsemss`)
3. Create a new database user with a strong password
4. **Add the user to the database** with **ALL PRIVILEGES**

> **Note:** cPanel prepends your username. If your cPanel user is `john`, the database will be `john_sijsemss` and user `john_dbuser`.

---

## Step 5: Run the Web Installer

1. Open your browser and navigate to:
   ```
   https://yourdomain.com/install.php
   ```

2. The installer will guide you through:
   - **Server Requirements** — checks PHP version, extensions, permissions
   - **Database Configuration** — enter your MySQL credentials and test
   - **Site & Email Settings** — configure URL and SMTP
   - **Admin Account** — choose demo data or clean install
   - **Installation** — runs migrations, seeds data, creates keys

3. After installation completes, **save the login credentials shown**

---

## Step 6: Post-Installation Security

### Delete the installer
```bash
rm ~/sijsemss/install.php
# Or delete via cPanel File Manager
```

### Verify storage link
If the installer warned about the storage symlink:
```bash
cd ~/sijsemss
php artisan storage:link
```

---

## Step 7: Set Up Cron Job (Optional but Recommended)

Laravel's task scheduler needs a cron job:

1. Go to **cPanel → Cron Jobs**
2. Add a new cron job:
   - **Schedule:** Once per minute (`* * * * *`)
   - **Command:**
     ```
     cd /home/yourusername/sijsemss && php artisan schedule:run >> /dev/null 2>&1
     ```

---

## Step 8: File Permissions

If you encounter permission issues:

```bash
cd ~/sijsemss
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

On some hosts you may need:
```bash
chmod -R 777 storage
chmod -R 777 bootstrap/cache
```

---

## Email Configuration Guide

### cPanel Email (Recommended)
1. Create an email account in **cPanel → Email Accounts** (e.g., `noreply@yourdomain.com`)
2. In the installer, use:
   - **Driver:** SMTP
   - **Host:** `mail.yourdomain.com`
   - **Port:** `587` (TLS) or `465` (SSL)
   - **Username:** `noreply@yourdomain.com`
   - **Password:** The email account password
   - **From:** `noreply@yourdomain.com`

### Gmail SMTP
1. Enable 2-factor auth on your Google account
2. Create an **App Password** at https://myaccount.google.com/apppasswords
3. Use:
   - **Host:** `smtp.gmail.com`
   - **Port:** `587`
   - **Username:** `your@gmail.com`
   - **Password:** The app password (NOT your Gmail password)

### Sendmail (Simplest)
- Just select **Sendmail** in the installer
- Emails will be sent via the server's sendmail binary
- May end up in spam if SPF/DKIM not configured

---

## Troubleshooting

### 500 Internal Server Error
- Check `storage/logs/laravel.log` for details
- Ensure `.env` exists and has correct values
- Run `php artisan config:clear` via Terminal

### "Class not found" errors
- Run `composer dump-autoload` via Terminal
- Or re-upload the `vendor/` folder

### Blank page
- Set `APP_DEBUG=true` in `.env` temporarily to see errors
- Check PHP error logs in cPanel → Error Log

### Session/login issues
- Make sure `storage/framework/sessions/` is writable
- The installer uses `file` session driver instead of `database` for reliability

### Storage/uploads not working
- Verify symlink: `ls -la public/storage` should point to `../../storage/app/public`
- If broken, run: `php artisan storage:link`

---

## Updating

1. Back up your database and `.env` file
2. Upload new files (excluding `.env`, `storage/`, and `vendor/`)
3. Run via Terminal:
   ```bash
   cd ~/sijsemss
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---


### Default Login Credentials (from DatabaseSeeder)

| Role     | Email                   | Password      |
|----------|-------------------------|---------------|
| Admin    | admin@shareij.com       | password123   |
| Editor   | editor@shareij.com      | password123   |
| Reviewer | sarah@shareij.com       | password123   |
| Author   | author@shareij.com      | password123   |

> **Note:** Failed login? Run `php artisan db:seed` if the database is empty.
