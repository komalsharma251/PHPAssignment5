# 💻 PHP Tech Support Management System

**Author:** Komal Sharma  
**Project Type:** Web Application (PHP, MySQL)  
**Framework Style:** MVC Architecture  
**Version:** Includes Incident Assignment & Update Features  

---

## 🌟 Overview

This is a **Tech Support Management System** built using:

- PHP
- MySQL
- Bootstrap
- Session Management

The system allows:

- Admin users to manage products, technicians, customers, and incidents
- Technicians to update assigned incidents
- Role-based authentication and authorization

---

# 🛠 Features

## 🔐 Authentication & Authorization
- Secure Login / Logout
- Role-based access (Admin, Technician, Customer)
- Session management
- Protected routes

---

## 👨‍💼 Admin Features

### 📦 Product Management
- Add products
- View products
- Delete products

### 👨‍🔧 Technician Management
- Add technicians
- Update technicians
- Delete technicians

### 👥 Customer Management
- Search customers by last name
- Update customer information

### 📋 Incident Management
- Create incidents
- Assign incidents to technicians
- View assigned/unassigned incidents

---

## 🧑‍🔧 Technician Features

- View assigned incidents
- Update incident description
- Close incidents
- Refresh incident list
- Logout functionality

---

# 📌 New Projects Implemented

---

## 🔵 Project 20-2: Assign Incidents

### 📄 Select Incident Page
- Displays all incidents where `techID IS NULL`
- Uses **JOIN** between:
  - `incidents`
  - `customers`
- Admin selects an incident
- Incident ID stored in `$_SESSION`

---

### 👨‍🔧 Select Technician Page
- Displays all technicians
- Shows number of open incidents
- Uses **correlated subquery**
- Technician ID stored in `$_SESSION`

---

### ✅ Assign Incident Page
- Updates selected incident with technician ID
- Shows success or error message
- Option to select another incident

---

## 🟢 Project 20-3: Update Incidents

### 🔐 Technician Login
- After login, technician sees:
  - Incidents assigned to them
  - Only open incidents

---

### 📋 Select Incident Page
- Displays:
  - Assigned incidents
  - Not yet closed incidents
- If no incidents:
  - Displays message
  - Shows "Refresh List" link

---

### ✏ Update Incident Page
- Technician can:
  - Edit description
  - Enter closed date
- Click **Update Incident**
- Displays confirmation message
- Logout option available

---

## 🟡 Project 20-4: Display Incidents

### 📂 Unassigned Incidents Page
- Shows incidents where:
  - `techID IS NULL`
- Displays:
  - Customer name
  - Product name
  - Incident ID
  - Date opened
  - Title
  - Description
- Admin can view assigned incidents

---

### 📂 Assigned Incidents Page
- Shows all assigned incidents
- Displays:
  - Customer name
  - Product name
  - Technician name
  - Incident ID
  - Date opened
  - Title
  - Description
  - Date closed (or "OPEN" if not closed)

---

# 🗄 Database

- MySQL database
- Uses JOIN queries
- Uses correlated subqueries
- Uses session variables
- Normalized structure

---

# 📁 Project Structure


PHPAssignment5/
├── account/
├── auth/
├── assets/
├── db/
├── models/
├── views/
│ ├── admin/
│ ├── technicians/
├── index.php


---

# ⚙ Installation & Setup

## 1️⃣ Clone Repository


git clone https://github.com/komalsharma251/PHPAssignment5.git


## 2️⃣ Setup Server
- Use XAMPP / MAMP / LAMP
- Place project inside `htdocs`
- Start Apache & MySQL

## 3️⃣ Database Setup
- Import SQL file from `/db`
- Update database connection in `db/app.php`

## 4️⃣ Configure Base URL

```php
define('BASE_URL', 'http://localhost/WEBSITES/PHPAssignment5');
🔑 Admin Login

Create admin user using:

INSERT INTO users (email, password_hash, role, first_name, last_name)
VALUES ('admin@example.com', 'hashed_password', 'admin', 'Admin', 'User');
🧰 Technologies Used

PHP 8+

MySQL

Bootstrap 5

MVC Architecture

Sessions

SQL JOIN

Correlated Subqueries

📜 License

MIT License © Komal Sharma
