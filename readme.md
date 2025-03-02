# AskQuestion Web Application

## Table of Contents

- [Overview](#overview)
  - [Features](#features)
  - [Technologies Used](#technologies-used)
  - [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
  - [Prerequisites](#prerequisites)
  - [Setting Up the Environment](#setting-up-the-environment)
  - [Running the Application Locally](#running-the-application-locally)
  - [Database Configuration](#database-configuration)
  - [Web Server Configuration](#web-server-configuration)
  - [Troubleshooting](#troubleshooting)
- [Folder Structure](#folder-structure)
- [Security Considerations](#security-considerations)
- [License](#license)
- [Contribution Guidelines](#contribution-guidelines)

# Overview

The AskQuestion web application is a platform where users can ask questions, provide answers, and engage in discussions on various topics. The system supports user authentication, question management, and user interaction features to create a dynamic Q&A community.

# Features

- User authentication (Signup, Login, Logout)
- Ask and answer questions
- Comment on answers
- Responsive design using Bootstrap
- Secure password hashing for authentication

# Technologies Used

- Frontend: HTML, CSS, JavaScript, Bootstrap
- Backend: PHP
- Database: MySQL
- Version Control: Git

# System Requirements

- PHP 7.4 or later
- MySQL 5.7 or later
- Apache or Nginx Web Server

# Installation Guide

## Prerequisites

Ensure that the following software is installed on your system:

- PHP
- MySQL Database Server
- Apache/Nginx
- Git (for version control)

## Setting Up the Environment

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/Ayahusu/askquestion.git](https://github.com/Ayahusu/askquestion.git) #Replace with your repo URL
    ```
2.  **Navigate to the project directory:**
    ```bash
    cd askquestion
    ```

## Running the Application Locally

1.  **Start the local development server:**
    ```bash
    php -S localhost:8000
    ```
2.  **Open a browser and go to:**
    ```
    http://localhost:8000
    ```

## Database Configuration

1.  **Create a MySQL database:**
    ```sql
    CREATE DATABASE discuss;
    ```
2.  **Import the database schema:**
    ```bash
    mysql -u root -p discuss < database/schema.sql
    ```
    - Ensure that the `database/schema.sql` file is located in the `database/` directory.
3.  **Configure database connection in `config/database.php`:**
    ```php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "discuss";
    ```
    - **Note:** For production environments, it is strongly recommended to use environment variables to store database credentials.

## Web Server Configuration

**Apache Example:**

Create a `.htaccess` file in your project root with the following:

```apacheconf
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```
