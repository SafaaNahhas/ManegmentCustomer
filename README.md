## Introduction
This project is a Customer and Payment and order Management System built using Laravel, designed to manage customers and their associated payments and orders. The API provides full CRUD (Create, Read, Update, Delete) functionality for customers and payments  and orders, with advanced features including relationship management, custom query scopes, and enhanced pivot table capabilities. The system adheres to RESTful standards, ensuring accurate HTTP status codes, data validation, and error handling.

## Prerequisites
PHP >= 8.0
Composer
Laravel >= 9.0
MySQL or any other database supported by Laravel
Postman for testing API endpoints
## Setup
1. **Clone the project:**:

git clone https://github.com/SafaaNahhas/ManegmentCustomer.git
cd TeamProjectManagement
## Install backend dependencies:
composer install
Create the .env file:

cp .env.example .env
## Modify the .env file to set up your database connection:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
## Generate the application key:


php artisan key:generate
## Run migrations:

php artisan migrate
## Start the local server:


php artisan serve
You can now access the project at http://localhost:8000.

## Project Structure
- `CustomerController.php`: Handles API requests related to Customer, such as creating, updating, deleting, and retrieving Customer.
- `PaymentController.php`: Handles API requests related to payments, including adding payments to customers and retrieving specific payment details.
- `OrderController.php`: Manages API requests related to  order, including creating and updating order profiles.
- `AuthController.php`: Manages API requests related to user authentication, including registration, login, and token management.
- `CustomerService.php`: Contains business logic for managing Customer.
- `PaymentService.php`: Contains business logic for managing Payment.
- `OrderService.php`: Contains business logic for managing Order.
- `AuthService.php`: Contains business logic for user authentication, including validating credentials and generating JWT tokens.
- `CustomerRequest.php`: A Form Request class for validating data in Customer.
- `PaymentRequest.php`: A Form Request class for validating data in Payment.
- `OrderRequest.php`: A Form Request class for validating data in Order.

## Postman Collection
A Postman collection is provided to test the API endpoints. Import it into your Postman application to run the requests.

Postman Documentation
https://documenter.getpostman.com/view/34501481/2sAXqzYK2C
