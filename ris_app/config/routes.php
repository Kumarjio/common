<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

include_once (APPPATH . 'helpers/inflector_helper.php');

$path = explode('/', $_SERVER['REQUEST_URI']);
if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '192.168.1.29') {
  @$controller = null;
  if(@$path[2] == 'admin'){
    @$controller = $path[3];  
  }
} else {
  @$controller = null;
  if(@$path[1] == 'admin'){
    @$controller = $path[2];  
  }
}



$route['admin/' . $controller] = 'admin/' . plural($controller) . "/view" . ucwords($controller);
$route['admin/' . $controller . '/list'] = 'admin/' . plural($controller) . "/view" . ucwords($controller);
$route['admin/' . $controller . '/view/(:num)'] = 'admin/' . plural($controller) . "/view" . ucwords($controller) . "/$1";
$route['admin/' . $controller . '/view/(:num)/(:any)'] = 'admin/' . plural($controller) . "/view" . ucwords($controller) . "/$1/$2";
$route['admin/' . $controller . '/add'] = 'admin/' . plural($controller) . "/add" . ucwords($controller);
$route['admin/' . $controller . '/edit/(:num)'] = 'admin/' . plural($controller) . "/edit" . ucwords($controller) . "/$1";
$route['admin/' . $controller . '/delete/(:num)'] = 'admin/' . plural($controller) . "/delete" . ucwords($controller) . "/$1";
$route['admin/' . $controller . '/getjson'] = 'admin/' . plural($controller) . "/getJsonData";
$route['admin/' . $controller . '/getjson/(:any)'] = 'admin/' . plural($controller) . "/getJsonData/$1";
$route['admin/' . $controller . '/getjson/(:any)/(:any)'] = 'admin/' . plural($controller) . "/getJsonData/$1/$2";

$route['admin/get_sub_cat_bussiness/(:num)'] = 'admin/ajax/getAllBussinessSubCategoryFromBussinessCategory/$1';

//Default
$route['default_controller'] = "welcome/index";
$route['404_override'] = '';

/*
* ADMIN SIDE URLS
*/

//Authenticate
$route['admin'] = "admin/dashboard/index";
$route['admin/dashboard'] = "admin/dashboard/index";
$route['admin/login'] = "admin/authenticate/index";
$route['admin/validate'] = "admin/authenticate/validateUser";
$route['admin/logout'] = "admin/authenticate/logout";
$route['admin/forgot_password'] = "admin/authenticate/userForgotPassword";
$route['admin/send_reset_password_link'] = "admin/authenticate/userSendResetPasswordLink";
$route['admin/reset_password/(:any)'] = "admin/authenticate/userResetPassword/$1";

//System Setting
$route['admin/system_setting/(:any)'] = "admin/systemsettings/viewSystemSetting/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */