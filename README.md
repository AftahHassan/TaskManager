# 🚀 TaskManager - Laravel Task Management Application

## 📌 Project Description

TaskManager est une application web moderne développée avec Laravel permettant aux utilisateurs de gérer efficacement leurs tâches quotidiennes grâce à une interface intuitive, une authentification sécurisée et un dashboard centralisé.

---

# ✨ Features

## 🔐 Authentication System

Built with Laravel Breeze:

* User Registration
* User Login
* Secure Logout
* Session Management
* Protected Routes

---

## 📋 Task CRUD System

Users can:

* ➕ Create tasks
* 👀 View tasks
* ✏️ Edit tasks
* ❌ Delete tasks

---

## 🗂️ Categories Management

Each task belongs to a category:

* Travail
* Études
* Personnel
* Urgent

---

## 📊 Dashboard

Central dashboard includes:

* Total tasks
* Pending tasks
* In-progress tasks
* Completed tasks
* Recent tasks overview

---

# 🛠️ Built With

* **Laravel 13**
* **PHP 8+**
* **MySQL**
* **Blade**
* **Tailwind CSS**
* **Vite**
* **Laravel Breeze**
* **Laravel Debugbar**
* **Laravel Telescope**

---

# 📂 Project Structure

```text
TaskManager/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   └── TaskController.php
│   │
│   └── Models/
│       ├── User.php
│       ├── Task.php
│       └── Category.php
│
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
│
├── resources/views/
│   ├── welcome.blade.php
│   ├── dashboard.blade.php
│   └── tasks/
│
└── routes/
    └── web.php
```

---

# 🗄️ Database Schema

## Users Table

* id
* name
* email
* password
* timestamps

## Categories Table

* id
* name
* timestamps

## Tasks Table

* id
* title
* description
* status
* user_id
* category_id
* timestamps

---

# 🔗 Relationships

### User

```php
User hasMany(Task::class)
```

### Category

```php
Category hasMany(Task::class)
```

### Task

```php
Task belongsTo(User::class)
Task belongsTo(Category::class)
```

---

# ⚙️ Installation

## 1️⃣ Clone Repository

```bash
git clone https://github.com/AftahHassan/TaskManager.git
cd TaskManager
```

---

## 2️⃣ Install Dependencies

```bash
composer install
npm install
```

---

## 3️⃣ Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### Configure `.env`

```env
DB_DATABASE=taskmanager
DB_USERNAME=root
DB_PASSWORD=
```

---

## 4️⃣ Run Migrations + Seeders

```bash
php artisan migrate:fresh --seed
```

---

## 5️⃣ Run Application

### Laravel Server:

```bash
php artisan serve
```

### Vite Server:

```bash
npm run dev
```

---

# 👤 Default Categories Seeder

```text
Travail
Études
Personnel
Urgent
```

---

# 🔒 Security Logic

Each user accesses only their own tasks:

```php
Task::where('user_id', auth()->id())
```

For global task display:

```php
Task::with(['category', 'user'])
```

---

# 🧪 Development Tools

## Laravel Debugbar

Used for:

* Query debugging
* Performance monitoring
* N+1 detection

## Laravel Telescope

Used for:

* Request tracking
* Exception monitoring
* Logs inspection

---

# 📸 User Flow

```text
Splash Screen
   ↓
Login / Register
   ↓
Dashboard
   ↓
Task CRUD Management
```

---

# 📈 Current Progress

## ✅ Completed

* Project Setup
* Database Design
* Models
* Migrations
* Seeders
* Authentication
* Splash Screen
* Routing
* Controllers

## 🚧 In Progress

* Dashboard UI
* Task Views
* Frontend Enhancements

---

# 🚀 Future Improvements

* Admin Panel
* Role Management
* Task Search
* Notifications
* Deadlines
* API Integration
* Dark Mode

---

# 👨‍💻 Author

## Hassan AFTAH

---


