# 🌸 Floral Culture POS System

A modern Point of Sale (POS) and Inventory Management System developed for florists and small retail businesses. Floral Culture streamlines inventory tracking, customer management, supplier management, sales processing, and receipt generation through a simple web-based interface.

---

## 📖 Overview

Floral Culture POS was built to digitize the daily operations of a flower shop by replacing manual inventory and sales tracking with a centralized web application.

The system allows administrators and staff to manage products, suppliers, customers, purchases, and sales while automatically maintaining inventory records and generating receipts for completed transactions.

---

## ✨ Features

### 📦 Inventory Management
- Add, edit and delete products
- Product image uploads
- Product categorization
- Real-time stock tracking

### 🛒 Sales Management
- Shopping cart system
- Checkout process
- Receipt generation
- Order confirmation

### 👥 Customer Management
- Register customers
- Store customer information
- Customer purchase tracking

### 🚚 Supplier Management
- Add suppliers
- Manage supplier information
- Purchase management

### 📊 Reporting
- Sales reports
- Purchase reports
- Inventory overview

### 🔐 Authentication
- Secure login system
- Administrator dashboard
- Session management

### 📧 Email Notifications
- Automatic receipt emails using PHPMailer
- SMTP email integration
- Environment variable configuration for secure credentials

---

# 🛠️ Technologies Used

| Technology | Purpose |
|------------|---------|
| PHP | Backend Development |
| MySQL | Database |
| HTML5 | Structure |
| CSS3 | Styling |
| JavaScript | Client-side Functionality |
| Composer | Dependency Management |
| PHPMailer | Email Receipts |
| PHP Dotenv | Environment Variable Management |
| XAMPP | Local Development Environment |

---

# 📂 Project Structure

```
FLORAL CULTURE/
│
├── Admin/
├── Assets/
├── customer/
├── Includes/
├── Pages/
├── Products/
├── Supplier/
├── Uploads/
├── vendor/
├── composer.json
├── composer.lock
├── config.php
├── .env.example
└── README.md
```

---

# ⚙️ Installation

## 1. Clone the repository

```bash
git clone https://github.com/emanuelk-dev/floral-culture-pos.git
```

## 2. Move the project

Place the project inside your XAMPP htdocs directory.

Example:

```
C:\xampp\htdocs\
```

---

## 3. Install Composer dependencies

```bash
composer install
```

---

## 4. Configure Environment Variables

Copy

```
.env.example
```

to

```
.env
```

Update the following variables:

```env
DB_HOST=localhost
DB_NAME=floral_culture
DB_USER=root
DB_PASSWORD=

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM=your-email@gmail.com
MAIL_FROM_NAME=Floral Culture
```

---

## 5. Create the Database

Create a MySQL database named:

```
floral_culture
```

Import the provided SQL database file into MySQL using phpMyAdmin.

---

## 6. Start XAMPP

Start:

- Apache
- MySQL

---

## 7. Open the application

```
http://localhost/FLORAL%20CULTURE/
```

---


---

# 🔒 Security

Sensitive credentials are not stored in the source code.

The application uses:

- Environment Variables (.env)
- Composer
- PHP Dotenv

to securely manage configuration values.

---

# 🚀 Future Improvements

- Barcode Scanner Integration
- Receipt Printing
- Role-Based Permissions
- Sales Analytics Dashboard
- Low Stock Notifications
- Export Reports to PDF & Excel
- Multi-Branch Support
- Customer Loyalty Program

---

# 🤝 Contributing

Contributions, suggestions and improvements are welcome.

1. Fork the repository
2. Create a feature branch

```
git checkout -b feature/new-feature
```

3. Commit your changes

```
git commit -m "Add new feature"
```

4. Push your branch

```
git push origin feature/new-feature
```

5. Open a Pull Request

---

# 👨‍💻 Author

**Shamran Kyeswa**

GitHub

https://github.com/emanuelk-dev

Email

shamrankyeswa@gmail.com

---

# 📄 License

This project is licensed under the MIT License.

---

## ⭐ Support

If you found this project useful, consider giving it a ⭐ on GitHub.
