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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['control'] = 'auth/Login';
$route['login'] = 'auth/Login'; 
$route['adminlogout'] = 'auth/Login/Logout';
$route['admindologin'] = 'auth/Login/VerifyLogin';
// $route['front-login'] = 'auth/Login/verifyLoginFront';
$route['sign-up'] = 'auth/Register';
$route['register'] = 'auth/Register/put';
$route['verify/(:any)'] = 'auth/Register/verify/$1';

$route['doreset'] = 'front/ResetPass/doReset';
$route['successful_reset'] = 'front/SuccessfulReset';
$route['password_reset'] = 'front/ResetPass';
$route['set_password'] = 'front/SetPassword';


// Front-end routes
$route['accounts'] = 'front/Accounts'; 
$route['user_dashboard'] = 'welcome';
$route['front-login'] = 'auth/Login/verifyLoginFront';
$route['register'] = 'front/Register';

$route['register-user'] = 'front/Register/register_user';


// Back-end routes
$route['dashboard'] = 'admin/Dashboard';
$route['create-customer'] = 'admin/Dashboard/create';
$route['customers-update'] = 'admin/Dashboard/update';
$route['customers-delete'] = 'admin/Dashboard/delete';
$route['customer-db-config'] = 'admin/CustomerDB';
$route['customer-db-setup'] = 'admin/CustomerDB/create';
$route['create-database'] = 'admin/CustomerDB/create_database';



$route['callback'] = 'Mpesa/insertIpay';
$route['logout'] = 'front/Signup/logout';

