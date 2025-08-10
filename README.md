# 🍽️ Food Fusion

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/TailwindCSS-4.0-06B6D4?style=for-the-badge&logo=tailwindcss" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
</p>

Recipe sharing platform built with Laravel.

---

## 📖 About

A simple community platform where users can

-   📚 View recipes uploaded either by certified chefs, experts or the platform itself.
-   ✍️ Upload recipes on the community forum, and
-   💬 Interact with each other (not real time)

## ✨ Features

### ✅ Current

-   Recipe CRUD operations
-   User authentication
-   Recipe categorization (tags, difficulty levels)
-   Basic search functionality
-   Responsive UI with TailwindCSS

### 🚀 Planned

-   Search with filter
-   User favorites
-   Comments
-   Photo upload with Cloudinary
-   Ingredient management

## 🔧 Tech Stack

| Component | Technology              |
| --------- | ----------------------- |
| Backend   | Laravel 12              |
| Frontend  | Blade + TailwindCSS 4.0 |
| Database  | MySQL                   |
| Server    | Apache (Laragon)        |
| DB Tool   | DBeaver                 |
| Build     | Vite 6.2                |

---

## ⚡ Setup

### 📋 Requirements

-   PHP 8.2+
-   Composer
-   Node.js & npm
-   MySQL
-   Laragon (or similar)

### 🛠️ Installation

1. 📥 Clone repository

    ```bash
    git clone https://github.com/HoDoR54/food-fusion.git
    cd food-fusion
    ```

2. 📦 Install dependencies

    ```bash
    composer install
    npm install
    ```

3. ⚙️ Environment setup

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. 🗄️ Database

    ```bash
    php artisan migrate --seed
    ```

5. 🎨 Assets

    ```bash
    npm run build
    ```

6. 🚀 Serve
    ```bash
    php artisan serve
    ```

<h2 align="center">✨ <strong>Please Feel Free to Contribute or Open an Issue</strong> ✨</h2>
