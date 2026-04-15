# 🥛 Dairy Delights

A PHP-based web application for managing and ordering dairy products online. The system includes user authentication, product management, order processing, subscription features, and an admin panel for complete control.

---

## 🚀 Features

### 👤 User Side

* User Registration & Login
* Browse Dairy Products
* Add to Cart
* Place Orders
* Subscription System
* Profile Management
* Order Tracking
* Feedback & Reviews

---

### 🛠️ Admin Panel

* Admin Login System
* Add / Edit / Delete Products
* Manage Orders
* Manage Users
* Handle Subscriptions
* View Customer Feedback
* Manage Payments

---

### 📦 Additional Functionalities

* Email Sending System (PHP Mail)
* OTP Verification (Admin/User)
* UPI Payment Interface
* Return & Refund System

---

## 🧰 Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Database:** MySQL
* **Server:** WAMP / XAMPP
* **Other:** Node.js (for additional scripts if used)

---

## 📁 Project Structure

```id="p1q9rm"
Dairy-Delights/
│
├── admin/                 # Admin panel files
├── assets/                # CSS, JS, images (if structured)
├── uploads/               # User uploads (ignored in Git)
│
├── index.php              # Main homepage
├── home.php               # User home
├── login.php              # Login system
├── signup.php             # Registration system
├── cart.html              # Cart UI
├── product.php            # Product display
├── save_order.php         # Order processing
├── subscription_form.html # Subscription UI
├── return_product.php     # Return system
│
├── db_connection_example.php  # Sample DB config
├── dairy_products.sql         # Main database
├── userdb.sql                 # User database
│
├── README.md              # Project documentation
```

---

## ⚙️ Setup Instructions (Run Locally)

1. Install **WAMP / XAMPP**

2. Place project folder inside:

   ```
   /www (WAMP) OR /htdocs (XAMPP)
   ```

3. Start Apache & MySQL

4. Import database:

   * Open phpMyAdmin
   * Create database (e.g., `dairy_products`)
   * Import:

     * `dairy_products.sql`
     * `userdb.sql`

5. Configure database:

   * Create your own `db_connection.php`
   * Add your credentials:

     ```php
     mysqli_connect("localhost", "root", "", "dairy_products");
     ```

6. Run project:

   ```
   http://localhost/NP/Dairy_product/
   ```

---

## 🔐 Security Notes

* Database configuration files are excluded using `.gitignore`
* Do not upload real credentials to GitHub
* Use sample config files for reference

---

## 📸 Screenshots

<img width="1902" height="898" alt="image" src="https://github.com/user-attachments/assets/9475a638-5c56-48c7-a939-e3f47f4882a8" />

* Homepage
* Product Listing
* Cart & Checkout
* Admin Panel

---

## 📌 Future Enhancements

* Online Payment Gateway Integration
* Fully Responsive UI
* Product Search & Filters
* Email Notifications for Orders
* Deployment on Cloud Hosting

---

## 👨‍💻 Authors

* Ayush Vyas
* Aarchi Patel

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub!

---
