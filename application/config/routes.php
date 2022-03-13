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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['emailtest'] = 'Home/emailtest';

//$route['createMap'] = 'createMap';

$route['cronjob'] = 'Cronjob';
$route['home'] = 'Home';
$route['about-us'] = 'Home/aboutUs';
$route['gallery'] = 'Home/gallery';
$route['rooms'] = 'Home/rooms';
$route['privacy-policy'] = 'Home/privacyPolicy';
$route['terms-and-conditions'] = 'Home/termsAndConditions';
$route['contact'] = 'Home/contact';
$route['login'] = 'Home/login';
$route['register'] = 'Home/register';
$route['forgot-password'] = 'Home/forgotPassword';

$route['dashboard/(:any)'] = 'Home/dashboard/$1';


$route['buynow'] = 'Home/buyNow';

$route['products'] = 'Home/products';
$route['product/(:any)'] = 'Home/product/$1';
$route['roomDetails/(:any)'] = 'Home/roomDetails/$1';
$route['bookRoom/(:any)'] = 'Home/bookRoom/$1';


$route['logout'] = 'Home/logout';

$route['feedback'] = 'Home/feedback';
$route['sendOTP'] = 'Home/sendOTP';
$route['varifyEmail/(:any)'] = 'Home/varifyEmail/$1';
$route['resetPassword/(:any)'] = 'Home/resetPassword/$1';
$route['resetPasswordSubmit'] = 'Home/resetPasswordSubmit';
$route['getPaymentGatewayResponse'] = 'Home/getPaymentGatewayResponse';
$route['cancelBooking/(:any)/(:any)'] = 'Home/cancelBooking/$1/$2';




$route['admin'] = 'Login';



