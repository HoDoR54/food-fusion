# 🍽️ Food Recipe sharing platform built with Laravel 12 and modern web technologies.

---

## 📖 About

Food Fusion is a comprehensive community platform where users can:

-   📚 Browse recipes from certified chefs, experts, and community members
-   ✍️ Create and share their own recipes with detailed steps and ingredients
-   📝 Write and read culinary blogs
-   🎉 Discover and participate in food-related events
-   👤 Build their culinary profile and connect with other food enthusiasts
-   💬 Comment and vote on recipes and content
-   📊 Access admin dashboard for content moderationn

<img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP Version">
<img src="https://img.shields.io/badge/TailwindCSS-4.0-06B6D4?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

Recipe sharing platform built with Laravel.

---

## 📖 About

A comprehensive community platform where users can:

-   📚 Browse recipes from certified chefs, experts, and community members
-   ✍️ Create and share their own recipes with detailed steps and ingredients
-   📝 Write and read culinary blogs
-   🎉 Discover and participate in food-related events
-   � Build their culinary profile and connect with other food enthusiasts
-   💬 Comment and vote on recipes and content
-   📊 Access admin dashboard for content moderation

## ✨ Features

### ✅ Current

**Core Functionality:**

-   **Recipe Management**: Full CRUD operations with approval workflow
-   **User Authentication**: JWT-based login/register with role-based permissions
-   **Blog System**: Create, read, and manage culinary blog posts
-   **Events System**: Browse and manage food-related events
-   **User Profiles**: Personal profiles with username-based URLs

**Advanced Features:**

-   **Permission System**: Role-based access control (Admin, User roles)
-   **Image Handling**: Cloudinary integration for photo uploads
-   **PDF Generation**: Download recipes as PDF documents
-   **Comment & Voting System**: Interactive community engagement

### 🚀 Planned

-   A dedicated frontend using Next.js or Vue.js
-   More advanced admin dashboard
-   Real-time notifications
-   Performance enhancement
-   TypeScript support

## 🏗️ Architecture

Food Fusion is built with a modern, scalable architecture featuring:

-   **Laravel 12**: Latest PHP framework with streamlined file structure
-   **JWT Authentication**: Secure token-based authentication system
-   **Role-Based Permissions**: Admin and user role management
-   **Cloudinary Integration**: Professional image handling and optimization
-   **Docker Containerization**: Complete development and deployment environment
-   **TailwindCSS 4.0**: Modern utility-first CSS framework
-   **MySQL Database**: Reliable relational database with optimized queries

## 🔧 Tech Stack

| Component        | Technology              |
| ---------------- | ----------------------- |
| Backend          | Laravel 12              |
| Frontend         | Blade + TailwindCSS 4.0 |
| Database         | MySQL                   |
| Authentication   | JWT (Firebase PHP-JWT)  |
| File Storage     | Cloudinary              |
| PDF Generation   | DomPDF                  |
| Testing          | Pest 3.8                |
| Code Quality     | Laravel Pint            |
| Build Tool       | Vite 6.2                |
| Icons            | Lucide                  |
| Dev Environment  | Laravel Sail / Docker   |
| Containerization | Docker & Docker Compose |

---

## ⚡ Setup

The application can be deployed using either Docker (recommended) or traditional PHP setup.

### 📋 Requirements

**Docker Deployment**

-   Docker & Docker Compose
-   Cloudinary account (for image uploads)

**Traditional Setup**

-   PHP 8.2+
-   Composer
-   Node.js & npm
-   MySQL
-   Cloudinary account (for image uploads)

### 🛠️ Installation

#### 🐳 Docker Deployment

```bash
# Clone and setup
git clone https://github.com/HoDoR54/food-fusion.git
cd food-fusion
cp .env.example .env

# Configure environment variables in .env
# - DB_DATABASE=food_fusion
# - DB_PASSWORD=your_secure_password
# - Cloudinary credentials

# Build and start
docker-compose up -d --build

# Setup database
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan key:generate
```

**Access Points:**

-   Website: http://localhost
-   phpMyAdmin: http://localhost:8080
-   Database: localhost:3306

#### 💻 Traditional Setup

```bash
# Clone and install
git clone https://github.com/HoDoR54/food-fusion.git
cd food-fusion
composer install
npm install

# Environment and database
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Build assets and serve
npm run build
php artisan serve
```
