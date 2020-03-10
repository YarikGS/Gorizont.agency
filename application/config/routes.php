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
|	https://codeigniter.com/user_guide/general/routing.html
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

// $route['language_get'] = 'Language/ajaxLanguageGet';
$route['language_change'] = 'Language/languageChange';


$route['admin_login'] = 'Login/login';
//$route['admin_registration'] = 'Login/create_user';
// $route['activate/(:num)/(:any)'] = 'Login/activate/$1/$2';
$route['admin_logout'] = 'Login/logout';
// $route['forgot_password'] = 'Login/forgot_password';
// $route['reset_password/(:any)'] = 'Login/reset_password/$1';

//ADMIN AREA
// $route['admin_home'] = 'Admin/Admin/index';

$route['admin'] = 'Admin/Admin/index';
$route['admin/add_element_main/(:num)'] = 'Admin/Admin/element_add/$1';
$route['admin/edit_element_main/(:num)/(:num)'] = 'Admin/Admin/element_edit/$1/$2';
$route['admin/delete_element_main/(:num)/(:num)'] = 'Admin/Admin/element_delete/$1/$2';

$route['admin/get_element_main/(:num)/(:num)'] = 'Admin/Admin/element_modal/$1/$2';

$route['get_tables_pages'] = 'Guest/get_tables_pages';

$route['admin/portfolio'] = 'Admin/Portfolio/index';
$route['admin/portfolio/(:num)'] = 'Admin/Portfolio/portfolio/$1';
$route['admin/admin_add_portfolio'] = 'Admin/Portfolio/portfolio_add';
$route['admin/admin_edit_portfolio/(:num)'] = 'Admin/Portfolio/portfolio_edit/$1';
$route['admin/admin_delete_portfolio/(:num)'] = 'Admin/Portfolio/portfolio_delete/$1';

$route['admin/case_handler/(:num)'] = 'Admin/Case_handler/index/$1';
$route['admin/get_element/(:num)/(:num)'] = 'Admin/Case_handler/element_modal/$1/$2';

$route['admin/add_element/(:num)/(:num)'] = 'Admin/Case_handler/element_add/$1/$2';
$route['admin/edit_element/(:num)/(:num)'] = 'Admin/Case_handler/element_edit/$1/$2';
$route['admin/delete_element/(:num)/(:num)'] = 'Admin/Case_handler/element_delete/$1/$2';


//ADMIN AREA END

//GUEST AREA
$route['portfolio'] = 'Guest/portfolio';
$route['case/(:num)'] = 'Guest/case/$1';
//GUEST AREA END

$route['default_controller'] = 'Guest/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
