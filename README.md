# 🛍️ Online Shopping Website – DBMS Mini Project

A fully functional e-commerce system with customer, admin, and supplier panels using:

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## 📁 Project Structure

- `index.php` – Homepage (product listing)
- `register.php`, `login.php` – Customer authentication
- `cart.php`, `checkout.php` – Cart management and ordering
- `admin/` – Admin panel (manage products/categories)
- `supplier/` – Supplier panel (view supplied products)
- `includes/db.php` – Database connection file
- `css/style.css` – Styling
- `sql/schema.sql` – Database schema

## ✅ Features

- Customer registration & login
- Product browsing & cart
- Checkout with payment
- Admin: add/manage products/categories
- Supplier: view their products
- Order & payment tracking structure

## 🧑‍💻 How to Run

1. Install **XAMPP** or **WAMP** and start Apache & MySQL.
2. Place the project folder in `htdocs/`.
3. Import `sql/schema.sql` into phpMyAdmin (create database `onlineshop` first).
4. Open `http://localhost/online-shopping` in your browser.

## 👨‍🔧 Default Data

You can add an admin and suppliers directly via phpMyAdmin using:

```sql
INSERT INTO Admin (AdminName, AdminRole) VALUES ('admin1', 'manager');
INSERT INTO Supplier (SupplierName, SupplierAddress, ContactNo) VALUES ('Acme Corp', 'Delhi', '9876543210');
