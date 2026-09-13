# ECF2 - Absences Management

Web application developed as part of the **DWWM training program – ECF 2 BACKEND**.

The application allows trainers to manage trainees and their absences, while providing attendance statistics.

## Technologies

- PHP 8.4+
- Symfony 7.4
- Doctrine ORM
- Twig
- Bootstrap
- MySQL

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/campsaurele/ecf2-Aurele.git
cd ecf2-Aurele
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure the database

Create a MySQL database named "ecf2aurele" and configure the connection in the `.env` file.

On windows

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/ecf2aurele?serverVersion=8.0"
```

On Mac

```env
DATABASE_URL="mysql://root:root@127.0.0.1:8889/ecf2aurele?serverVersion=8.0"
```

Adapt the connection settings to your local environment.

### 4. Create the database structure

Run the migrations:

```bash
symfony console d:m:m
```

### 5. Start the development server

```bash
symfony serve
```

The application will be available at the URL provided by Symfony, usually:

```text
https://127.0.0.1:8000 or 8001
```

## Features

- View attendance statistics
- Manage trainees
- Add, edit and delete absences
- Add trainee profile pictures
- Upload PDF absence justifications
- Display trainees with more than 5 unjustified absences
- View detailed statistics as a trainer
- Estimate the financial impact of absences

## Authentication

Trainee and absence management requires authentication.

In the login page, a button has been created to setup a single Admin Account. Login and Password are given.

Administrative features and financial statistics are restricted to users with the appropriate role.

## Database

The `Training` and `Reason` table is managed directly through the database administration interface and is not exposed through the application's CRUD interface.

## Important

The `.env` file contains local environment configuration and database credentials. It should **not** be committed to the repository.

The `vendor/` directory is also not required in the repository and is recreated with:

```bash
composer install
```
