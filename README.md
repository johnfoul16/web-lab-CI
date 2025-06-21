## TechSnap 
TechSnap is a user-friendly online shopping system simplifies everyday shopping, allowing customers to shop from home and receive deliveries. Ideally for gaming enthusiasts who likes gaming peripherals. It allows users to create accounts, manage profiles, browse products, add items to cart, track deliveries and view order history. Administrators can manage inventory and dashboards, ensuring speed, convenience, and accessibility.

## Setup and installation instructions (Web Hosting)

# Set Up Hosting Environment
- Follow this steps from these YouTube tutorials:
-   𝘩𝘵𝘵𝘱𝘴://𝘸𝘸𝘸.𝘺𝘰𝘶𝘵𝘶𝘣𝘦.𝘤𝘰𝘮/𝘸𝘢𝘵𝘤𝘩?𝘷=𝘬𝘛𝘧𝘶𝘡𝘻𝘶𝘸𝘤𝘻𝘨
-  𝘩𝘵𝘵𝘱𝘴://𝘸𝘸𝘸.𝘺𝘰𝘶𝘵𝘶𝘣𝘦.𝘤𝘰𝘮/𝘸𝘢𝘵𝘤𝘩?𝘷=𝘠_𝘚𝘊_𝘔𝘟𝘪𝘎𝘓𝘠
- Created a free hosting account at 𝘪𝘯𝘧𝘪𝘯𝘪𝘵𝘺𝘧𝘳𝘦𝘦.𝘯𝘦𝘵.
- In the accounts dashboard, click the accounts tab in the navigation bar and look the 'Domains' section.
- Click 'Add Domain' button, after redirecting, click 'Add Subdomain' under the Subdomain which is the only free domain that InfinityFree offers. 
- After clicking, you can type your desired domain name and the free domain extension. 

# Deploy the Application
- Upload the CodeIgniter 3 project files to the htdocs folder of the
InfinityFree’s online file manager using an FTP client as what the hosting platform recommended to avoid broken file uploads.
- Set the hostname, username, password, and port in the FileZilla (FTP) app to connect in the InfinityFree's server. 
- This credentials can be found under the 'FTP Details' tab of the InfinityFree's account dashboard.
- After connecting to the server, manage your project files or the entire folder remotely. The 'Local Site' in the left side of the app is your computer's file directory while the 'Remote Site' on the right side is the server's file directory.
- Simply drag all the files from your project's directory in the Local Site (if necessary) to the 'Remote Site' side to upload them remotely.
- If succesful, you can configure the content of each file of your project in the InfinityFree's online file manager which can be found in the account's dashboard for the following steps.
- Navigate to 𝘩𝘵𝘥𝘰𝘤𝘴/𝘢𝘱𝘱𝘭𝘪𝘤𝘢𝘵𝘪𝘰𝘯/𝘤𝘰𝘯𝘧𝘪𝘨/𝘤𝘰𝘯𝘧𝘪𝘨.𝘱𝘩𝘱 of the online file manager, right-click the file then find and click the edit. 
- Set the correct base URL using the hosting platform’s provided free subdomain (𝘩𝘵𝘵𝘱𝘴://𝘵𝘦𝘤𝘩𝘴𝘯𝘢𝘱 𝘪𝘯𝘧𝘪𝘯𝘪𝘵𝘺𝘧𝘳𝘦𝘦𝘢𝘱𝘱.𝘤𝘰𝘮/) and click save.
- Since InfinityFree also host database server, navigate to the accounts dashboard and click the 'Control Panel'.
- Scroll and look for the 'DATABASES' section then click 'MySQl Databases'.
- Look for 'Create New Database' section. Under 'New Database', input your desired database name then click create database afterwards. 
- The new database will appear below the 'Current Databases' section, simply click the 'Admin' button on the right side of a database in the list to redirect to its database server.
- You can manually setup the tables or import an sql file at your discretion.

# Environment Variables
- Go the online file manager and navigate to 𝘩𝘵𝘥𝘰𝘤𝘴/𝘢𝘱𝘱𝘭𝘪𝘤𝘢𝘵𝘪𝘰𝘯/𝘤𝘰𝘯𝘧𝘪𝘨/𝘥𝘢𝘵𝘢𝘣𝘢𝘴𝘦.𝘱𝘩𝘱 right-click the file then find and click the edit.
    - Configure the database details such as hostname, username, password, and database using the 'MySQL Connection Details' in the infinityfree account's dashboard under the 'MySQL Databases' tab. Refer to the example below:
    - 'hostname' => 'sql105.infinityfree.com',
    - 'username' => 'if0_39134217',
    - 'password' => '[your actual password here]',
    - 'database' => 'if0_39134217_ecommerce_db'

## Note
It can take up to 72 hours for new domains to be accessible everywhere. This was due to DNS propagation delay, which is normal for new subdomains on shared/free hosting platforms. Try waiting for 4 to 24 hours (72 houts if possible) then check if the website is functional.

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
git clone https://github.com/johnfoul16/web-lab-CI.git ta3

This will clone the repository into a folder named ta3.

Import Database:

Start Apache and MySQL from your XAMPP control panel.

Open your web browser and go to http://localhost/phpmyadmin/.

Click on "New" in the left sidebar to create a new database.

Enter ecommerce_db as the database name and click "Create".

Select the newly created ecommerce_db from the left sidebar.

Click on the "Import" tab.

Click "Choose File" and select the ecommerce_db.sql file located in the root of your ta3 project folder (e.g., C:\xampp\htdocs\ta3\ecommerce_db.sql).

Scroll down and click "Go" to import the database.

Configure CodeIgniter:

Navigate to your project's configuration files: C:\xampp\htdocs\ta2\application\config\

config.php:

Open config.php.

Find $config['base_url'] = ''; and change it to:

$config['base_url'] = 'http://localhost/ta3/';

Find $config['csrf_protection'] = FALSE; and ensure it's set to TRUE for security:

$config['csrf_protection'] = TRUE;

database.php:

Open database.php.

Find the $db['default'] array and update your database credentials:

$db['default'] = array(
    'dsn'      => ''
    'hostname' => 'localhost'
    'username' => 'root'
    'password' => '' 
    'database' => 'ecommerce_db'
    'dbdriver' => 'mysqli'
    'dbprefix' => ''
    'pconnect' => FALSE
    'db_debug' => (ENVIRONMENT !== 'production')
    'cache_on' => FALSE
    'cachedir' => ''
    'char_set' => 'utf8'
    'dbcollat' => 'utf8_general_ci'
    'swap_pre' => ''
    'encrypt'  => FALSE
    'compress' => FALSE
    'stricton' => FALSE
    'failover' => array()
    'save_queries' => TRUE
);

Run the Application:

Open your web browser and go to:
http://localhost/ta3/

Default Admin/User Credentials
For initial testing and demonstration, you can use the following credentials:

Admin Account:

Username: admin

Email: admin@gmail.com

Password: 1234567890

Standard User Account:

Username: user

Email: user@example.com

Password: 1234567890 (You can change this after logging in)

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


### User Management:


-  View all registered users.

-  Edit user details (username, email, role, password).

-  Delete user accounts (with safeguards against self-deletion).


### General Features


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