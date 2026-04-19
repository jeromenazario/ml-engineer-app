

# ML / AI Engineer Application System
### A PDO-Based CRUD Web Application | Web Development Activity
---

## 📌 Project Overview

This is a full-stack web application built to manage **Machine Learning / AI Engineer** job applicants. The system allows users to **Create, Read, Update, and Delete (CRUD)** applicant records stored in a MySQL database — all powered by **PHP PDO (PHP Data Objects)** for secure, prepared-statement-based database interactions.

The goal of this project is to build a functional **application management system** using PDO methods, following the folder structure and conventions discussed in lectures.

---

## 🗂️ Files

| File | Description |
|---|---|
| `index.php` | Displays all applicant records in a table with Edit and Delete actions. |
| `create.php` | Form to add a new applicant record to the database. |
| `update.php` | Form to edit and update an existing applicant record. |
| `delete.php` | Handles deletion of an applicant record by ID. |
| `config/database.php` | PDO database connection class. |
| `database.sql` | SQL script to create the `ml_engineer_db` database and `applicants` table. |

---

## 🗄️ Database Structure

**Database:** `ml_engineer_db`
**Table:** `applicants`

| Column | Type | Description |
|---|---|---|
| `id` | INT (PK, AI) | Primary key, auto-incremented |
| `first_name` | VARCHAR(100) | Applicant's first name |
| `last_name` | VARCHAR(100) | Applicant's last name |
| `email` | VARCHAR(150) | Email address |
| `specialization` | VARCHAR(100) | ML/AI field (e.g., NLP, Computer Vision) |
| `programming_lang` | VARCHAR(100) | Primary programming language |
| `years_experience` | INT | Years of relevant experience |
| `education_level` | VARCHAR(50) | Highest educational attainment |
| `date_added` | TIMESTAMP | Auto-set on record creation |

---

## 🛠️ Technologies Used

- PHP 8 (PDO with prepared statements)
- MySQL (via XAMPP)
- HTML5 / CSS3
- Bootstrap 5 (via CDN)
- Apache (XAMPP local server)

---

## 🚀 How to Run

1. Install and launch **XAMPP**, then start **Apache** and **MySQL**.
2. Open **phpMyAdmin** (`http://localhost/phpmyadmin`) and run the `database.sql` script to create the database and table.
3. Place the `ml-engineer-app` folder inside your XAMPP `htdocs` directory:
   ```
   /Applications/XAMPP/htdocs/ml-engineer-app/
   ```
4. Open your browser and go to:
   ```
   http://localhost/ml-engineer-app/
   ```

---

## ✨ Features

- **Create** — Submit a new ML/AI Engineer applicant via a validated form
- **Read** — View all applicants in a clean, sortable table
- **Update** — Edit any existing applicant record
- **Delete** — Remove a record with a confirmation prompt
- Success/error flash messages on all CRUD operations
- Input validation on both Create and Update forms

---

## 👤 About

**Course:** Web Development  
**Project Type:** PDO CRUD Application  
**Purpose:** School Activity — PHP PDO Methods & Database Integration  
**Dream Job:** Machine Learning / AI Engineer

---

Just copy everything between the horizontal lines and paste it into your GitHub repo's README! Let me know if you want to tweak anything.
