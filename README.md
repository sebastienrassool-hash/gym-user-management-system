# FitTrack Gym User Management System

## Requirements
- XAMPP (Apache + MySQL + PHP 8 recommended)
- Web browser
- phpMyAdmin

## Setup
1. Copy the `gym_user_management_system` folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open `http://localhost/phpmyadmin`.
4. Import `database.sql`.
5. Check the database settings in `config.php` (default XAMPP settings are root with an empty password).
6. Open `http://localhost/gym_user_management_system/`.
7. Log in as admin with username `admin` and password `Admin123!`.
8. Register a normal member account to test the member dashboard.
9. Change the demo admin password before using this outside a classroom demo.

## Features mapped to the assessment
- Bootstrap 5 responsive navigation, cards, forms, alerts, modal and grid.
- JavaScript form validation plus change, mouseover and mouseout events.
- PHP GET query messages and POST form processing; reusable include/require files.
- MySQL database with users and memberships tables, MySQLi prepared statements, insert/select/update/delete.
- Password hashing, login sessions, logout and admin/member access control.

## Important
The demo admin password hash is supplied in `database.sql`. The site is intended for a local classroom project. Before public deployment, add CSRF protection, stronger error handling, HTTPS, rate limiting and a secure admin password.
