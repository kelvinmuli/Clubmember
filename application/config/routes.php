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

$route['logon/(:any)'] = 'auth/Login/index/$1';
$route['nmra'] = 'auth/Login/nmra';
$route['control'] = 'auth/Login';
$route['control/(:any)'] = 'auth/Login/index/$1';
$route['login'] = 'auth/Login'; 
$route['login/(:any)'] = 'auth/Login/index/$1'; 
$route['reset'] = 'auth/Login/resetPassword';
$route['reset/(:any)'] = 'auth/Login/resetPassword/$1';
$route['reset/(:any)/(:any)'] = 'auth/Login/resetPassword/$1/$2';
$route['reset-now'] = 'auth/Login/resetNowPassword';
$route['adminlogout'] = 'auth/Login/Logout';
$route['admindologin'] = 'auth/Login/VerifyLogin';
// $route['front-login'] = 'auth/Login/verifyLoginFront';
$route['forgot-password'] = 'admin/AuthController/forgotPassword';
$route['forgot-password/(:any)'] = 'admin/AuthController/forgotPassword/$1';
$route['forgot-password/(:any)/(:any)'] = 'auth/Login/resetPassword/$1/$2';
$route['forgot-password-now'] = 'admin/AuthController/resetPasswordNow';

/*
* admin/UserController
*/
$route['all-user/(:any)'] = 'admin/UserController/userView/$1';
$route['all-user/(:any)/(:any)'] = 'admin/UserController/userView/$1/$2';
$route['member/(:any)'] = 'admin/UserController/memberView/$1';
$route['member/(:any)/(:any)'] = 'admin/UserController/memberView/$1/$2';
$route['profile'] = 'admin/UserController/profileView';
$route['profile/(:any)'] = 'admin/UserController/profileView/$1';
$route['profile/(:any)/(:any)'] = 'admin/UserController/profileView/$1/$2';
$route['profile/(:any)/(:any)/(:any)'] = 'admin/UserController/profileView/$1/$2/$3';
$route['get-user-list/(:any)/(:any)'] = 'admin/UserController/getUserList/$1/$2';
$route['add-user-modal/(:any)'] = 'admin/UserController/addUserModal/$1';
$route['add-user-modal/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2';
$route['add-user-modal/(:any)/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2/$3';
$route['add-user-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2/$3/$4';
$route['add-user-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2/$3/$4/$5';
$route['add-user-modal/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/UserController/addUserModal/$1/$2/$3/$4/$5/$6';
$route['add-user'] = 'admin/UserController/addUser';
$route['approve-user-modal/(:any)/(:any)/(:any)'] = 'admin/UserController/approveUserModal/$1/$2/$3';
$route['approve-user-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/UserController/approveUserModal/$1/$2/$3/$4';
$route['approve-user'] = 'admin/UserController/approveUser';
$route['edit-user-modal/(:any)'] = 'admin/UserController/editUserModal/$1';
$route['edit-user-modal/(:any)/(:any)'] = 'admin/UserController/editUserModal/$1/$2';
$route['edit-user-modal/(:any)/(:any)/(:any)'] = 'admin/UserController/editUserModal/$1/$2/$3';
$route['edit-user-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/UserController/editUserModal/$1/$2/$3/$4';
$route['edit-user'] = 'admin/UserController/editUser';
$route['delete-user-modal/(:any)'] = 'admin/UserController/deleteUserModal/$1';
$route['delete-user-modal/(:any)/(:any)'] = 'admin/UserController/deleteUserModal/$1/$2';
$route['delete-user-modal/(:any)/(:any)/(:any)'] = 'admin/UserController/deleteUserModal/$1/$2/$3';
$route['delete-user'] = 'admin/UserController/deleteUser';
$route['import-user-modal/(:any)'] = 'admin/UserController/importUserModal/$1';
$route['import-user-modal/(:any)/(:any)'] = 'admin/UserController/importUserModal/$1/$2';
$route['import-user-modal/(:any)/(:any)/(:any)'] = 'admin/UserController/importUserModal/$1/$2/$3';
$route['download-user-import-template'] = 'admin/UserController/downloadUserImportTemplate';
$route['import-users'] = 'admin/UserController/importUsers';
$route['api/add-user-muthaiga'] = 'admin/UserController/addUserMuthaiga';


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
$route['overview-card'] = 'admin/HomeController/overviewCard';


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

/*
* admin/SubscriptionController
*/
$route['subscription'] = 'admin/SubscriptionController';
$route['subscription/(:any)'] = 'admin/SubscriptionController/subscriptionView/$1';
$route['add-subscription-modal'] = 'admin/SubscriptionController/addSubscriptionModal';
$route['add-subscription-modal/(:any)'] = 'admin/SubscriptionController/addSubscriptionModal/$1';
$route['add-subscription'] = 'admin/SubscriptionController/addSubscription';
$route['view-subscription-modal/(:any)'] = 'admin/SubscriptionController/viewSubscriptionModal/$1';
$route['view-subscription-modal/(:any)/(:any)'] = 'admin/SubscriptionController/viewSubscriptionModal/$1/$2';
$route['subscription-approval-modal/(:any)/(:any)/(:any)'] = 'admin/SubscriptionController/subscriptionApprovalModal/$1/$2/$3';
$route['subscription-approval-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/SubscriptionController/subscriptionApprovalModal/$1/$2/$3/$4';
$route['subscription-approval-modal/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin/SubscriptionController/subscriptionApprovalModal/$1/$2/$3/$4/$5';
$route['add-membership-fee-type'] = 'admin/SubscriptionController/addMembershipFeeType';
$route['add-membership-fee-type-modal'] = 'admin/SubscriptionController/addMembershipFeeTypeModal';
$route['get-membership-fee-type/(:any)'] = 'admin/SubscriptionController/getMembershipFeeType/$1';
$route['approve-subscription-modal/(:any)/(:any)'] = 'admin/SubscriptionController/approveSubscriptionModal/$1/$2';
$route['approve-subscription'] = 'admin/SubscriptionController/approveSubscription';
$route['send-payment-reminder/(:any)/(:any)'] = 'admin/SubscriptionController/sendPaymentReminder/$1/$2';
$route['payment-info-modal/(:any)'] = 'admin/PayController/paymentInfoModal/$1';
$route['payment-info-modal/(:any)/(:any)'] = 'admin/PayController/paymentInfoModal/$1/$2';
$route['pay-modal/(:any)'] = 'admin/PayController/payModal/$1';
$route['pay-modal/(:any)/(:any)'] = 'admin/PayController/payModal/$1/$2';
$route['pay-modal/(:any)/(:any)/(:any)'] = 'admin/PayController/payModal/$1/$2/$3';
$route['pay-modal/(:any)/(:any)/(:any)/(:any)'] = 'admin/PayController/payModal/$1/$2/$3/$4';
$route['pay'] = 'admin/SubscriptionController/pay';
$route['callback'] = 'admin/PayController/insertIpay';


$route['logout'] = 'front/Signup/logout';


/*
* admin/AGMMinutesController
*/
$route['agm-minutes'] = 'admin/AgmMinutesController/agmMinutesView';
$route['add-agm-minutes-modal'] = 'admin/AgmMinutesController/addAgmMinutesModal';
$route['add-agm-minutes'] = 'admin/AgmMinutesController/addAgmMinutes';
$route['view-agm-minutes-modal/(:any)'] = 'admin/AgmMinutesController/viewAgmMinutesModal/$1';
$route['edit-agm-minutes-modal/(:any)'] = 'admin/AgmMinutesController/editAgmMinutesModal/$1';
$route['edit-agm-minutes'] = 'admin/AgmMinutesController/editAgmMinutes';
$route['remove-agm-minutes-modal/(:any)'] = 'admin/AgmMinutesController/removeAgmMinutesModal/$1';
$route['remove-agm-minutes'] = 'admin/AgmMinutesController/removeAgmMinutes';

/*
* admin/NewsletterController
*/
$route['newsletter'] = 'admin/NewsletterController/newsletterView';
$route['add-newsletter-modal'] = 'admin/NewsletterController/addNewsletterModal';
$route['add-newsletter'] = 'admin/NewsletterController/addNewsletter';
$route['view-newsletter-modal/(:any)'] = 'admin/NewsletterController/viewNewsletterModal/$1';
$route['edit-newsletter-modal/(:any)'] = 'admin/NewsletterController/editNewsletterModal/$1';
$route['edit-newsletter'] = 'admin/NewsletterController/editNewsletter';
$route['send-newsletter/(:any)'] = 'admin/NewsletterController/sendNewsletter/$1';
$route['remove-newsletter-modal/(:any)'] = 'admin/NewsletterController/removeNewsletterModal/$1';
$route['remove-newsletter'] = 'admin/NewsletterController/removeNewsletter';

/*
* admin/ProjectController
*/
$route['projects'] = 'admin/ProjectController/projectView';
$route['projects/(:any)'] = 'admin/ProjectController/projectView/$1';
$route['project'] = 'admin/ProjectController/projectView';
$route['project/(:any)'] = 'admin/ProjectController/projectView/$1';
$route['add-project-modal'] = 'admin/ProjectController/addProjectModal';
$route['add-project'] = 'admin/ProjectController/addProject';
$route['view-project-modal/(:any)'] = 'admin/ProjectController/viewProjectModal/$1';
$route['edit-project-modal/(:any)'] = 'admin/ProjectController/editProjectModal/$1';
$route['edit-project'] = 'admin/ProjectController/editProject';
$route['remove-project-modal/(:any)'] = 'admin/ProjectController/removeProjectModal/$1';
$route['remove-project'] = 'admin/ProjectController/removeProject';

/*
* admin/PetitionSetupController
*/
$route['petition-setup'] = 'admin/PetitionSetupController/petitionSetupView';
$route['add-petition-setup-modal'] = 'admin/PetitionSetupController/addPetitionSetupModal';
$route['add-petition-setup'] = 'admin/PetitionSetupController/addPetitionSetup';
$route['view-petition-modal/(:any)'] = 'admin/PetitionSetupController/viewPetitionModal/$1';
$route['edit-petition-setup-modal/(:any)'] = 'admin/PetitionSetupController/editPetitionSetupModal/$1';
$route['edit-petition-setup'] = 'admin/PetitionSetupController/editPetitionSetup';
$route['remove-petition-setup-modal/(:any)'] = 'admin/PetitionSetupController/removePetitionSetupModal/$1';
$route['remove-petition-setup'] = 'admin/PetitionSetupController/removePetitionSetup';
$route['petition-signatures/(:any)'] = 'admin/PetitionSetupController/petitionSignatureView/$1';
$route['add-petition-signature-modal/(:any)'] = 'admin/PetitionSetupController/addPetitionSignatureModal/$1';
$route['add-petition-signature'] = 'admin/PetitionSetupController/addPetitionSignature';
$route['edit-petition-signature-modal/(:any)'] = 'admin/PetitionSetupController/editPetitionSignatureModal/$1';
$route['edit-petition-signature'] = 'admin/PetitionSetupController/editPetitionSignature';
$route['remove-petition-signature-modal/(:any)'] = 'admin/PetitionSetupController/removePetitionSignatureModal/$1';
$route['remove-petition-signature'] = 'admin/PetitionSetupController/removePetitionSignature';

// Petition signatures export (CSV / Excel)
$route['petition-signatures-export/(:any)'] = 'admin/PetitionSetupController/exportPetitionSignatures/$1';
$route['petition-signatures-export/(:any)/(:any)'] = 'admin/PetitionSetupController/exportPetitionSignatures/$1/$2';
$route['petition-signatures-export-html-modal/(:any)'] = 'admin/PetitionSetupController/exportHtmlModal/$1';


/*
* admin/PaymentHistoryController
*/
$route['payment-history'] = 'admin/PaymentHistoryController/paymentHistoryView';
$route['payment-history/(:any)'] = 'admin/PaymentHistoryController/paymentHistoryView/$1';
$route['payment-history/(:any)/(:any)'] = 'admin/PaymentHistoryController/paymentHistoryView/$1/$2';
$route['payment-receipt-modal/(:any)/(:any)'] = 'admin/PaymentHistoryController/paymentReceiptModal/$1/$2';
$route['add-fundraising-payment-history-modal/(:any)'] = 'admin/PaymentHistoryController/addFundraisingPaymentHistoryModal/$1';
$route['view-fundraising-payment-history-modal/(:any)'] = 'admin/PaymentHistoryController/viewFundraisingPaymentHistoryModal/$1';
$route['add-fundraising-payment-history'] = 'admin/PaymentHistoryController/addFundraisingPaymentHistory';


/*
*
* admin/SecurityIncidentController
*/
$route['security-incident'] = 'admin/SecurityIncidentController/securityIncidentView';
$route['security-incidents'] = 'admin/SecurityIncidentController/securityIncidentView';
$route['security-incident/(:any)'] = 'admin/SecurityIncidentController/securityIncidentView/$1';
$route['add-security-incident-modal'] = 'admin/SecurityIncidentController/addSecurityIncidentModal';
$route['add-security-incident'] = 'admin/SecurityIncidentController/addSecurityIncident';
$route['view-security-incident-modal/(:any)'] = 'admin/SecurityIncidentController/viewSecurityIncidentModal/$1';
$route['edit-security-incident-modal/(:any)'] = 'admin/SecurityIncidentController/editSecurityIncidentModal/$1';
$route['edit-security-incident'] = 'admin/SecurityIncidentController/editSecurityIncident';
$route['remove-security-incident-modal/(:any)'] = 'admin/SecurityIncidentController/removeSecurityIncidentModal/$1';
$route['remove-security-incident'] = 'admin/SecurityIncidentController/removeSecurityIncident';

/*
* admin/FundraisingController
*/
$route['fundraising'] = 'admin/FundraisingController/fundraisingView';
$route['fundraising/(:any)'] = 'admin/FundraisingController/fundraisingView/$1';
$route['add-fundraising-modal'] = 'admin/FundraisingController/addEditFundraisingModal';
$route['add-fundraising'] = 'admin/FundraisingController/addFundraising';
$route['edit-fundraising-modal/(:any)'] = 'admin/FundraisingController/addEditFundraisingModal/$1';
$route['delete-fundraising-modal/(:any)'] = 'admin/FundraisingController/deleteFundraisingModal/$1';
$route['delete-fundraising'] = 'admin/FundraisingController/deleteFundraising';

/*
* admin/DatabaseController
*/
$route['customer'] = 'admin/CustomerController';

/*
* admin/NoticeBoardController
*/
$route['important-document'] = 'admin/ClubHQController';
$route['notice-board'] = 'admin/NoticeBoardController/noticeBoardView';
$route['view-notice-board-modal/(:any)'] = 'admin/NoticeBoardController/viewNoticeBoardModal/$1';
$route['add-notice-board'] = 'admin/NoticeBoardController/addNoticeBoard';
$route['add-notice-board-modal'] = 'admin/NoticeBoardController/addEditNoticeBoardModal';
$route['edit-notice-board'] = 'admin/NoticeBoardController/editNoticeBoard';
$route['edit-notice-board-modal/(:any)'] = 'admin/NoticeBoardController/addEditNoticeBoardModal/$1';
$route['remove-notice-board-modal/(:any)'] = 'admin/NoticeBoardController/removeNoticeBoardModal/$1';
$route['remove-notice-board'] = 'admin/NoticeBoardController/removeNoticeBoard';

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


/*
* admin/GlobalController
*/
$route['remove-global-data'] = 'admin/GlobalController/removeGlobalData';
