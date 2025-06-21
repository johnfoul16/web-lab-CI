
# CodeIgniter E-commerce Shop



## System Title and Description

This is a simple yet functional E-commerce Web Application built with the CodeIgniter 3 PHP framework. It allows users to browse products, add them to a shopping cart, and place orders. Administrators have full control over product management, user management, and can view sales reports.


## Setup and Installation Instructions (Local Environment - XAMPP)

Follow these steps to get the project up and running on your local machine using XAMPP.

## Prerequisites
XAMPP (or equivalent web server stack like WAMP/MAMP/Laragon) with:

Apache

MySQL

PHP (version compatible with CodeIgniter 3, e.g., PHP 7.x)

Git installed on your system.

##  Installation Steps
Clone the Repository:
Open your Git Bash or terminal and navigate to your XAMPP's htdocs directory (e.g., C:\xampp\htdocs). Then clone your project:

cd C:\xampp\htdocs
git clone https://github.com/johnfoul16/web-lab-CI.git ta2

This will clone the repository into a folder named ta2.

Import Database:

Start Apache and MySQL from your XAMPP control panel.

Open your web browser and go to http://localhost/phpmyadmin/.

Click on "New" in the left sidebar to create a new database.

Enter ecommerce_db as the database name and click "Create".

Select the newly created ecommerce_db from the left sidebar.

Click on the "Import" tab.

Click "Choose File" and select the ecommerce_db.sql file located in the root of your ta2 project folder (e.g., C:\xampp\htdocs\ta2\ecommerce_db.sql).

Scroll down and click "Go" to import the database.

Configure CodeIgniter:

Navigate to your project's configuration files: C:\xampp\htdocs\ta2\application\config\

config.php:

Open config.php.

Find $config['base_url'] = ''; and change it to:

$config['base_url'] = 'http://localhost/ta2/';

Find $config['csrf_protection'] = FALSE; and ensure it's set to TRUE for security:

$config['csrf_protection'] = TRUE;

database.php:

Open database.php.

Find the $db['default'] array and update your database credentials:

$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root', // Your MySQL username (default for XAMPP)
    'password' => '',     // Your MySQL password (default for XAMPP is empty)
    'database' => 'ecommerce_db', // The name of the database you created
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

Run the Application:

Open your web browser and go to:
http://localhost/ta2/

Default Admin/User Credentials
For initial testing and demonstration, you can use the following credentials:

Admin Account:

Username: admin

Email: admin@gmail.com

Password: 1234567890

Standard User Account:

Username: user

Email: user@example.com

Password: password123 (You can change this after logging in)

Features
## This e-commerce application provides the following core functionalities:

### User Module
-  User Registration & Login: Secure user authentication with password hashing and session management.

-  User Dashboard: Personalized landing page after login.

-  User Profile Management: Ability to view and update personal details (username, email).

-  Password Change: Secure method for users to update their password.

-  Order History: Users can view a list of their past orders.

-  View Order Details: Detailed view of individual orders.

### Product Module
-  Product Listing: Browse all available products in the shop.

-  Product Search: Filter products by name or description.

-  Shopping Cart: Add, view, and remove items from a persistent shopping cart.

-  Checkout Process: Complete orders with delivery details and payment method selection.

-  Stock Management: Automatic deduction of product stock upon order placement.

### Admin Module (Requires 'admin' role)
-  Admin Dashboard & Reports: Summary widgets displaying total sales, orders, and user count, along with recent orders and top-selling products.

### Product Management (CRUD):

-  Add Products: Create new product entries with name, description, price, stock, and image upload.

-  Edit Products: Modify existing product details, including image replacement.

-  Delete Products: Remove products from the database and associated image files from the server.

*******************
User Management:
*******************

-  View all registered users.

-  Edit user details (username, email, role, password).

-  Delete user accounts (with safeguards against self-deletion).

*******************
General Features
*******************

-  Flashdata Notifications: Provides transient feedback messages (success/error) after user actions.

-  CSRF Protection: Implemented for all form submissions to prevent Cross-Site Request Forgery attacks.

-  Responsive Design: Basic responsive layout using custom CSS for adaptability across devices.

-  Secure Password Hashing: Uses password_hash() (Bcrypt) for storing user passwords.

-  Image Upload Validation: Server-side validation for image type and size.

-  URL Helper Integration: Dynamic URL generation for improved portability.

-  Modular Architecture: Built with CodeIgniter's MVC pattern for clear separation of concerns.

*******************
Technologies Used
*******************

-  Backend: PHP 7.x

-  Framework: CodeIgniter 3

-  Database: MySQL (via phpMyAdmin for local setup)

-  Frontend: HTML5, CSS3, JavaScript

-  Styling: Bootstrap Icons

-  Version Control: Git & GitHub