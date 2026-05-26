# Student Organization System (SOS)

A Laravel web application for managing student organizations, memberships, events, announcements, and reports with role-based access for **Students**, **Officers**, and **Super Admins**.

## Tech Stack

- Laravel 9 (compatible with PHP 8.0+ on XAMPP)
- Blade templates + Bootstrap 5 (CDN)
- MySQL
- Laravel UI authentication (login, register, password reset, email verification)
- SweetAlert2 notifications
- Chart.js analytics dashboards

> **Note:** Your spec mentions Laravel 12, which requires PHP 8.2+. This project runs on **Laravel 9** to match your current PHP 8.0.30 environment. Upgrade PHP to 8.2+ before moving to Laravel 12.

## Features

### Student
- Register, login, email verification, profile editing
- Submit join requests with optional message; track **Pending Approval** status
- Cancel pending requests before review
- Browse and join organizations
- View events and announcements
- Leave organizations and track membership status

### Officer
- **Join Requests** page — see pending students with profile, course, and message
- Approve or reject with one click; badge shows pending count in sidebar
- Manage assigned organization (logo, cover, details)
- Create events and post announcements
- Generate member CSV reports
- Dashboard analytics

### Super Admin
- **Memberships** — view and approve/reject all pending join requests system-wide
- Manage students, officers, and organizations
- Approve/reject organizations
- System reports and settings
- Activate/deactivate accounts

## Project folder

All application code lives in `student-organization-management/`. The parent `SOS` folder should only contain this project (no extra `vendor` or `composer.json` at the root).

## Setup (XAMPP)

1. Start **Apache** and **MySQL** in XAMPP.
2. Create the database:
   ```sql
   CREATE DATABASE sos_db;
   ```
3. From the project folder:
   ```bash
   cd student-organization-management
   composer install
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```
4. Open http://127.0.0.1:8000

## Demo Accounts

| Role        | Email             | Password  |
|-------------|-------------------|-----------|
| Super Admin | admin@sos.edu     | password  |
| Officer     | officer@sos.edu   | password  |
| Student     | student@sos.edu   | password  |

## Environment

Copy `.env.example` to `.env` if needed. Default database settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sos_db
DB_USERNAME=root
DB_PASSWORD=
```

## Security

- Password hashing (bcrypt)
- CSRF protection
- Role middleware (`student`, `officer`, `super_admin`)
- Active account middleware
- Email verification on registration
