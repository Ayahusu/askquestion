AskQuestion Web Application

Table of Contents

Overview

Features

Technologies Used

System Requirements

Installation Guide

Prerequisites

Setting Up the Environment

Running the Application Locally

Database Configuration

Folder Structure

License

Overview

The AskQuestion web application is a platform where users can ask questions, provide answers, and engage in discussions on various topics. The system supports user authentication, question management, and user interaction features to create a dynamic Q&A community.

Features

User authentication (Signup, Login, Logout)

Ask and answer questions

Comment on answers

Responsive design using Bootstrap

Secure password hashing for authentication

Technologies Used

Frontend: HTML, CSS, JavaScript, Bootstrap

Backend: PHP

Database: MySQL

Version Control: Git

System Requirements

PHP 7.4 or later

MySQL 5.7 or later

Apache or Nginx Web Server

Composer (Optional for package management)

Installation Guide

Prerequisites

Ensure that the following software is installed on your system:

PHP

MySQL Database Server

Apache/Nginx

Git (for version control)

Setting Up the Environment

Clone the repository:

git clone https://github.com/your-repo/askquestion.git

Navigate to the project directory:

cd askquestion

Start the local development server:

php -S localhost:8000

Running the Application Locally

Open a browser and go to:

http://localhost:8000

Database Configuration

Create a MySQL database:

CREATE DATABASE discuss;

Import the database schema:

mysql -u root -p discuss < database/schema.sql

Configure database connection in config/database.php:

$host = "localhost";
$username = "root";
$password = "";
$dbname = "discuss";

Folder Structure

askquestion/
├── config/ # Database configuration
├── css/ # Stylesheets
├── includes/ # Common UI components (header, footer, etc.)
├── public/ # Static assets (images, banners, etc.)
├── server/ # Backend PHP scripts
├── index.php # Main entry point
└── README.md # Project documentation

License

This project is licensed under the MIT License.
