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
php artisan key:generate
# Edit the .env file with your DB credentials
php artisan migrate
php artisan serve
```

## Roadmap
- Implement the `forget-password` feature.
- Add notifications when a task is completed.
- Work with files to save or load tasks.
- Unit Testing.
