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
// FRONTEND
$route['default_controller'] = 'app';
// $route['states'] = 'states/page';
// $route['zip/(:num)'] = 'app/zip';
// $route['city/(:any)'] = 'app/city';
$route['search'] = 'search/index';
$route['states/(:num)'] = 'states/page';
$route['state/(:any)'] = 'states/city';
$route['state/(:any)/(:num)'] = 'states/city';
$route['blog'] = 'blog/page';
$route['blog/(:num)'] = 'blog/page';

// Industry
$route['industry/(:any)'] = 'industry/state';
$route['industry/(:any)/(:num)'] = 'industry/state';
$route['industry/(:any)/(:any)'] = 'industry/city';
$route['industry/(:any)/(:any)/(:num)'] = 'industry/city';
$route['city/(:any)/(:any)'] = 'industry/city_business';
$route['zip/(:any)/(:num)'] = 'industry/zip_business';

// ADMIN
$route['admin'] = 'admin/index';
$route['admin/page/update/(:any)'] = 'admin/page_update';

// Posts & Pages
$route['admin/page/updating'] = 'admin/page_update_process';
$route['admin/post/update/(:any)'] = 'admin/post_update';
$route['admin/post/updating'] = 'admin/post_update_process';

$route['admin/page/trashing'] = 'admin/trash_page_post';
$route['admin/page/recover'] = 'admin/recover_page_post';
$route['admin/page/delete'] = 'admin/delete_page_post';
$route['admin/pages/empty'] = 'admin/empty_page_post_trash';

// Category
$route['admin/category/update/(:any)'] = 'admin/category_update';
$route['admin/category/update'] = 'admin/category_update_process';

// State
$route['admin/state/update/(:any)'] = 'admin/state_update';
$route['admin/state/update'] = 'admin/state_update_process';
$route['admin/state/import'] = 'admin/state_import';
$route['admin/state/import/process'] = 'admin/state_import_process';
$route['admin/state/delete'] = 'admin/delete_state';
$route['admin/state/delete-all'] = 'admin/delete_all_state';

// Industry Admin
$route['admin/industry/new'] = 'admin/add_industry';
$route['admin/industry/add'] = 'admin/add_industry_process';
$route['admin/industry/delete'] = 'admin/delete_industry';
$route['admin/industry/update'] = 'admin/update_industry_process';
$route['admin/industry/(:any)'] = 'admin/update_industry';

// City
$route['admin/city/update/(:any)/(:any)'] = 'admin/city_update';
$route['admin/city/update'] = 'admin/city_update_process';
$route['admin/city/import'] = 'admin/city_import';
$route['admin/city/import/process'] = 'admin/city_import_process';
$route['admin/city/delete'] = 'admin/delete_city';
$route['admin/city/delete-all'] = 'admin/delete_all_city';

// Configuration
$route['admin/configuration/update'] = 'admin/config_update';
// User
$route['admin/user/detail/update'] = 'admin/user_detail_update';
$route['admin/user/password/update'] = 'admin/user_password_update';

$route['contact/send'] = 'app/contactProcess';

$route['(:any)'] = 'page/slug';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;