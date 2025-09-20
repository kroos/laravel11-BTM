# laravel11-BTM

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/Database-MySQL-orange?logo=mysql)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A Laravel-based web application for **Bahagian Teknologi Maklumat (BTM), UniSHAMS** to help record and manage tasks more effectively.

---

## Features

- User authentication (login / registration)
- Task recording and management to log BTM tasks for easier tracking and reporting
- Role / permissions (if implemented)
- Dashboard / overview of tasks
- Responsive UI (mobile & desktop)

---

## Technology Stack

- **Backend:** Laravel 11
- **Frontend:** Blade templates, JavaScript, Tailwind CSS / Bootstrap (depending on configuration)
- **Database:** MySQL / MariaDB
- **Tools:** Vite, PHPUnit, Composer, NPM

---

## Installation

1. Clone the repository

   ```bash
   git clone https://github.com/kroos/laravel11-BTM.git
   cd laravel11-BTM
   ```

2. Copy the environment file

   ```bash
   cp .env.example .env
   ```

3. Install PHP dependencies

   ```bash
   composer install
   ```

4. Install frontend dependencies

   ```bash
   npm install
   ```

5. Generate application key

   ```bash
   php artisan key:generate
   ```

6. Run database migrations

   ```bash
   php artisan migrate
   ```

7. Build frontend assets (development)

   ```bash
   npm run dev
   ```

   For production build:

   ```bash
   npm run build
   ```

8. Start the development server

   ```bash
   php artisan serve
   ```

---

## Usage

1. Open **http://localhost:8000** in your browser.
2. Register a new user account or log in with existing credentials.
3. Use the dashboard to create, update, and manage tasks.
4. If roles/permissions are enabled, assign roles to users as needed.

---

## Project Structure

| Path                   | Description                                              |
|------------------------|----------------------------------------------------------|
| `app/`                 | Core application logic (models, controllers, policies)   |
| `routes/`              | Route definitions (web.php, api.php)                     |
| `resources/views/`     | Blade view templates                                     |
| `resources/css`, `js`  | Frontend assets                                          |
| `database/migrations/` | Database migration files                                 |
| `database/seeders/`    | Database seeders (if any)                                |
| `tests/`               | Automated tests                                          |
| `.env.example`         | Example environment configuration                        |

---

## Contributing

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/your-feature`.
3. Commit your changes with clear messages.
4. Push the branch and open a Pull Request.

Please ensure code follows existing style and any tests pass.

---

## License

This project is open-source. Default: **MIT**. Update `LICENSE` file as needed.

---

## Contact

- **Repository:** https://github.com/kroos/laravel11-BTM
- **Institution:** Bahagian Teknologi Maklumat, UniSHAMS

---

