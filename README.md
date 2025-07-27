# Task manager (Laravel)

A simple task management web app built with Laravel.
Includes task creation, editing and deletion.

## Motivation

I worked with Laravel previously and I wanted to learn more about this framework.

## Tech stack

- Laravel 11+
- PHP 8.2
- MySQL
- Laravel Breeze (for authentication scaffolding)
- Blade templates with vanilla CSS

## Requirements

- Composer
- PHP 8.2
- MySQL

## Setup
```bash
git clone https://github.com/DavidMatias44/ll.git
cd ll
composer install
cp .env.example .env
php artisan ket:generate
# Edit the .env file with your DB credentials
php artisan migrate
php artisan serve
```

## Roadmap
- Add success and error messages
- Filter tasks by state or priority
- Use Laravel Policies (authorization logic)
