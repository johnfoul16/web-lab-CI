<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'UserController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// User Authentication & Core Routes - Handled by UserController
$route['register'] = 'UserController/register';
$route['login'] = 'UserController/login';
$route['logout'] = 'UserController/logout';
$route['dashboard'] = 'UserController/dashboard';
$route['profile'] = 'UserController/profile'; // New: User Profile Page
$route['change_password'] = 'UserController/change_password'; // New: Change Password Page

// Product Management (Admin) Routes - Handled by UserController
$route['products'] = 'UserController/index'; // Admin Product Listing
$route['products/create'] = 'UserController/create';
$route['products/store'] = 'UserController/store';
$route['products/edit/(:num)'] = 'UserController/edit/$1';
$route['products/update/(:num)'] = 'UserController/update/$1';
$route['products/delete/(:num)'] = 'UserController/delete/$1';
$route['reports'] = 'UserController/reports'; // New: Admin Reports Page
$route['manage_user'] = 'UserController/manage_user';

$route['manage_user/users/edit/(:num)'] = 'UserController/edit_user/$1'; // Edit a specific user
$route['manage_user/users/update/(:num)'] = 'UserController/update_user/$1'; // Process update for a specific user
$route['manage_user/users/delete/(:num)'] = 'UserController/delete_user/$1'; // Delete a specific user

// Shop and Cart Routes - Handled by ShopController
$route['shop'] = 'ShopController/shop';
$route['cart'] = 'ShopController/cart';
$route['add_to_cart/(:num)'] = 'ShopController/addToCart/$1'; // Route for adding to cart
$route['remove_from_cart/(:num)'] = 'ShopController/removeFromCart/$1'; // Route for removing from cart
$route['checkout'] = 'ShopController/completePayment'; // Route for payment completion
$route['order_history'] = 'ShopController/orderHistory';
$route['order_history/(:num)'] = 'ShopController/viewOrder/$1'; // Route to view specific order

// RESTful API Endpoints - Handled by ApiController
// Products
$route['api/products'] = 'ApiController/products_get';
$route['api/products/(:num)'] = 'ApiController/products_get/$1'; // Specific product by ID

// Orders
$route['api/order'] = 'ApiController/order_post'; // Handles POST requests for placing orders

// Users (example - replace with proper authentication/authorization in a real app)
$route['api/user/(:num)'] = 'ApiController/user_get/$1';




