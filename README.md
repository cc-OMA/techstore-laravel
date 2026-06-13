# TechStore

**Name:** ONUR METIN ASCI
**Student Number:** 20222022375

---

TechStore is a modern e-commerce web application developed with Laravel. The project allows users to browse products, search and filter items, manage their shopping cart, place orders, and review purchased products. Administrators can manage products, categories, stock, and customer orders through an admin panel.

---

## Features

### User Features

* User Registration & Login
* Product Listing
* Product Detail Pages
* Product Search
* Category Filtering
* Product Sorting
* Shopping Cart System
* Order Placement
* Order History
* Product Reviews & Ratings

### Admin Features

* Product Management (Create, Read, Update, Delete)
* Category Management
* Stock Tracking
* Order Management
* Dashboard Analytics
* Customer Review Monitoring

---

## Technologies Used

* Laravel 13
* PHP 8.5
* MySQL
* Bootstrap 5
* Blade Templates
* HTML5
* CSS3
* JavaScript

---

## Database Structure

Main tables used in the project:

* users
* products
* categories
* carts
* orders
* order_items
* reviews

---

## Installation

Clone the repository:

```bash
git clone https://github.com/cc-OMA/techstore-laravel.git
```

Move into the project folder:

```bash
cd techstore-laravel
```

Install dependencies:

```bash
composer install
npm install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure database settings inside the .env file and run:

```bash
php artisan migrate
```

Create storage link:

```bash
php artisan storage:link
```

Start the application:

```bash
php artisan serve
npm run dev
```

---

## Project Highlights

* Responsive e-commerce interface
* Product review and rating system
* Advanced product management
* Stock tracking
* Order history and administration
* Dashboard statistics
* Clean MVC architecture

---

## Author

Onur Metin AŞCI

Software Engineering Student

---

## License

This project was developed for educational purposes as part of an Advanced Web Development course.
