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

/*
* admin/DatabaseController
*/
$route['all-user/(:any)'] = 'admin/UserController/userView/$1';
$route['all-user/(:any)/(:any)'] = 'admin/UserController/userView/$1/$2';
$route['profile'] = 'admin/UserController/profileView';
$route['profile/(:any)'] = 'admin/UserController/profileView/$1';
$route['profile/(:any)/(:any)'] = 'admin/UserController/profileView/$1/$2';
$route['profile/(:any)/(:any)/(:any)'] = 'admin/UserController/profileView/$1/$2/$3';
$route['get-user-list/(:any)/(:any)'] = 'admin/UserController/getUserList/$1/$2';
$route['add-user-modal/(:any)'] = 'admin/UserController/addUserModal/$1';
$route['add-user-modal/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2';
$route['add-user'] = 'admin/UserController/addUser';


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
$route['dashboard'] = 'admin/HomeController';


/*
* admin/CustomerController
*/

$route['add-customer-modal'] = 'admin/CustomerController/addCustomerModal';
$route['add-customer-modal/(:any)'] = 'admin/CustomerController/addCustomerModal/$1';
$route['add-customer'] = 'admin/CustomerController/addCustomer';
$route['edit-customer-modal'] = 'admin/CustomerController/editCustomerModal';
$route['edit-customer-modal/(:any)'] = 'admin/CustomerController/editCustomerModal/$1';
$route['edit-customer'] = 'admin/CustomerController/editCustomer';
$route['remove-customer'] = 'admin/CustomerController/removeCustomer';
$route['remove-customer-modal'] = 'admin/CustomerController/removeCustomerModal';


$route['callback'] = 'Mpesa/insertIpay';
$route['logout'] = 'front/Signup/logout';

/*
* admin/DatabaseController
*/
$route['customer'] = 'admin/CustomerController';

/**
 * MaintenanceController
 */
$route['module-setup'] = 'admin/MaintenanceController/moduleSetupView';
$route['add-module-setup-modal/(:any)'] = 'admin/MaintenanceController/addModuleSetupModal/$1';
$route['add-module-setup'] = 'admin/MaintenanceController/addModuleSetup';
$route['add-module-setup/(:any)'] = 'admin/MaintenanceController/addModuleSetup/$1';
$route['all-maintenance'] = 'admin/MaintenanceController/maintenanceView';
$route['all-maintenance/(:any)'] = 'admin/MaintenanceController/maintenanceView/$1';
$route['all-maintenance/(:any)/(:any)'] = 'admin/MaintenanceController/maintenanceView/$1/$2';
$route['get-maintenance'] = 'admin/MaintenanceController/getMaintenance';
$route['get-maintenance/(:any)'] = 'admin/MaintenanceController/getMaintenance/$1';
$route['add-maintenance'] = 'admin/MaintenanceController/addMaintenance';
$route['add-maintenance-modal/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/addMaintenanceModal/$1/$2/$3';
$route['add-maintenance-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/addMaintenanceModal/$1/$2/$3/$4/$5';
$route['edit-maintenance'] = 'admin/MaintenanceController/editMaintenance';
$route['edit-maintenance-image-modal/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceImageModal/$1/$2/$3';
$route['edit-maintenance-image-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceImageModal/$1/$2/$3/$4';
$route['edit-maintenance-image-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceImageModal/$1/$2/$3/$4/$5';
$route['edit-maintenance-modal/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceModal/$1/$2/$3';
$route['edit-maintenance-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceModal/$1/$2/$3/$4';
$route['edit-maintenance-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/editMaintenanceModal/$1/$2/$3/$4/$5';
$route['remove-maintenance'] = 'admin/MaintenanceController/removeMaintenance';
$route['remove-maintenance-modal/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/removeMaintenanceModal/$1/$2/$3';
$route['remove-maintenance-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/removeMaintenanceModal/$1/$2/$3/$4';
$route['remove-maintenance-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/removeMaintenanceModal/$1/$2/$3/$4/$5';
$route['maintenance-naming'] = 'admin/MaintenanceController/maintenanceNamingView';
$route['maintenance-naming/(:any)'] = 'admin/MaintenanceController/maintenanceNamingView/$1';
$route['add-maintenance-naming-modal'] = 'admin/MaintenanceController/addMaintenanceNamingModal';
$route['add-maintenance-naming'] = 'admin/MaintenanceController/addMaintenanceNaming';
$route['edit-maintenance-naming-modal/(:any)'] = 'admin/MaintenanceController/editMaintenanceNamingModal/$1';
$route['edit-maintenance-naming'] = 'admin/MaintenanceController/editMaintenanceNaming';
$route['maintenance-column-naming'] = 'admin/MaintenanceController/maintenanceColumnNamingView';
$route['maintenance-column-naming/(:any)'] = 'admin/MaintenanceController/maintenanceColumnNamingView/$1';
$route['add-maintenance-column-naming-modal'] = 'admin/MaintenanceController/addMaintenanceColumnNamingModal';
$route['add-maintenance-column-naming'] = 'admin/MaintenanceController/addMaintenanceColumnNaming';
$route['edit-maintenance-column-naming-modal/(:any)'] = 'admin/MaintenanceController/editMaintenanceColumnNamingModal/$1';
$route['edit-maintenance-column-naming'] = 'admin/MaintenanceController/editMaintenanceColumnNaming';
$route['get-maintenance-column-html/(:any)'] = 'admin/MaintenanceController/getMaintenanceColumnHtml/$1';
$route['get-maintenance-column-html/(:any)/(:any)'] = 'admin/MaintenanceController/getMaintenanceColumnHtml/$1/$2';
$route['get-table-data/(:any)/(:any)'] = 'admin/MaintenanceController/getTableData/$1/$2';
$route['get-table-data/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/getTableData/$1/$2/$3';
$route['get-table-data/(:any)/(:any)/(:any)/(:any)'] = 'admin/MaintenanceController/getTableData/$1/$2/$3/$4';


/*
* admin/UserRoleController
*/
$route['user-role'] = 'admin/UserRoleController/userRoleView';
$route['user-role/(:any)'] = 'admin/UserRoleController/userRoleView/$1';
$route['user-role-add/(:any)'] = 'admin/UserRoleController/userRoleAdd/$1';
$route['user-role-delete/(:any)'] = 'admin/UserRoleController/userRoleDelete/$1';
$route['user-role-add-edit/(:any)'] = 'admin/UserRoleController/userRoleAddEdit/$1';
$route['user-sub-menu-role-add-edit/(:any)'] = 'admin/UserRoleController/userSubMenuRoleAddEdit/$1';
$route['user-module-type-role-add-edit/(:any)'] = 'admin/UserRoleController/userModuleTypeRoleAddEdit/$1';
$route['user-type-role'] = 'admin/UserRoleController/userTypeRoleView';
$route['user-type-role-add/(:any)'] = 'admin/UserRoleController/userTypeRoleAdd/$1';
$route['user-type-role-delete/(:any)'] = 'admin/UserRoleController/userTypeRoleDelete/$1';
$route['user-type-role-add-edit/(:any)'] = 'admin/UserRoleController/userTypeRoleAddEdit/$1';


/*
* admin/DatabaseController
*/
$route['customer-db-config'] = 'admin/DatabaseController';
$route['create-customer-database'] = 'admin/DatabaseController/createCustomerDatabase';
$route['customer-db-setup'] = 'admin/DatabaseController/create';
$route['create-database'] = 'admin/DatabaseController/create_database';

