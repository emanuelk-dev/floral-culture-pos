# Floral Culture Project - Setup Guide

This README explains how to run the **Floral Culture** PHP/MySQL project on another laptop and how to access/import the database.

---

## 1. Requirements

Install the following first:

- **XAMPP** with Apache, PHP, and MySQL
- **Composer**
- A browser such as Chrome
- The Floral Culture project folder
- The database export file, for example: `floral_culture.sql`

---

## 2. Copy the Project to XAMPP

1. Extract the project ZIP file.
2. Copy the folder named:

```text
FLORAL CULTURE
```

3. Paste it inside:

```text
C:\xampp\htdocs\
```

The final path should look like this:

```text
C:\xampp\htdocs\FLORAL CULTURE\
```

---

## 3. Start XAMPP

1. Open **XAMPP Control Panel**.
2. Start:
   - **Apache**
   - **MySQL**

Both should turn green.

---

## 4. Install PHP Dependencies

This project uses **PHPMailer** for sending receipt emails.

Open Command Prompt or VS Code terminal and run:

```bash
cd "C:\xampp\htdocs\FLORAL CULTURE"
composer install
```

This will create/update the `vendor` folder.

---

## 5. Create and Import the Database

### Option A: Using phpMyAdmin

1. Open this in your browser:

```text
http://localhost/phpmyadmin
```

2. Click **New**.
3. Create a database named:

```text
floral_culture
```

4. Click the new `floral_culture` database.
5. Go to **Import**.
6. Choose the database file:

```text
floral_culture.sql
```

7. Click **Go**.

The tables should now be imported.

---

## 6. Database Connection Details

The project connects to the database using this file:

```text
Includes/db_connection.php
```

Current database settings:

```php
$host = 'localhost';
$db = 'floral_culture';
$user = 'root';
$pass = '';
```

For normal XAMPP, this usually works because the default MySQL username is `root` and the password is empty.

If the other laptop uses a different MySQL password, update this line:

```php
$pass = '';
```

Example:

```php
$pass = 'your_mysql_password';
```

---

## 7. How to Access the Project in Browser

After Apache and MySQL are running, open:

```text
http://localhost/FLORAL%20CULTURE/Pages/index.php
```

Or go directly to the dashboard:

```text
http://localhost/FLORAL%20CULTURE/Pages/dashboard.php
```

Admin shop/POS page:

```text
http://localhost/FLORAL%20CULTURE/Admin/shop.php
```

Products page:

```text
http://localhost/FLORAL%20CULTURE/Admin/Products.php
```

Sales report:

```text
http://localhost/FLORAL%20CULTURE/Products/sales_report.php
```

---

## 8. How Someone Can Access Your Database

They do **not** automatically access the database just by opening the project folder. They need the database imported on their laptop.

To give them database access:

1. Open phpMyAdmin on your laptop:

```text
http://localhost/phpmyadmin
```

2. Select the database:

```text
floral_culture
```

3. Click **Export**.
4. Choose **Quick** export method.
5. Format should be **SQL**.
6. Click **Export**.
7. Send them the downloaded file, for example:

```text
floral_culture.sql
```

8. On their laptop, they import it into phpMyAdmin using the steps in Section 5.

Do not share your full XAMPP `mysql/data` folder unless you know what you are doing. Exporting the `.sql` file is cleaner and safer.

---

## 9. Email Receipt Setup

Receipt emails are handled in:

```text
Includes/send_receipt_email.php
```

The project currently uses Gmail SMTP through PHPMailer.

If email receipts fail, check:

- The Gmail address is correct.
- The Gmail App Password is correct.
- Composer dependencies are installed.
- Internet connection is available.

Important: do not expose your Gmail App Password publicly or upload it to GitHub. Store it safely or replace it before sharing the project.

---

## 10. Common Problems and Fixes

### Problem: Database connection failed

Check that:

- MySQL is running in XAMPP.
- The database name is exactly `floral_culture`.
- `Includes/db_connection.php` has the correct username and password.

### Problem: Page not found

Make sure the folder is inside:

```text
C:\xampp\htdocs\FLORAL CULTURE\
```

Then use:

```text
http://localhost/FLORAL%20CULTURE/Pages/dashboard.php
```

### Problem: Images are not showing

Make sure the `Uploads` folder is included in the copied project.

### Problem: Email receipts are not sending

Run:

```bash
composer install
```

Then confirm the Gmail SMTP settings in:

```text
Includes/send_receipt_email.php
```

---

## 11. Main Project Folders

```text
FLORAL CULTURE/
│
├── Admin/          # Admin pages, POS, cart, products
├── Assets/         # CSS and images
├── customer/       # Customer registration page
├── Includes/       # Database connection, navbar, email receipt logic
├── Pages/          # Login, dashboard, payment pages
├── Products/       # Sales, suppliers, purchases, customer details
├── Receipts/       # Receipt storage folder
├── Uploads/        # Product images
├── vendor/         # Composer dependencies
├── composer.json
└── composer.lock
```

---

## 12. Final Run Checklist

Before running the project, confirm:

- Apache is running.
- MySQL is running.
- Project folder is in `htdocs`.
- Database `floral_culture` has been imported.
- `Includes/db_connection.php` has the correct database details.
- Composer dependencies are installed.

Then open:

```text
http://localhost/FLORAL%20CULTURE/Pages/dashboard.php
```
