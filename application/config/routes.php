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
$route['student_evaluation/(:any)']	= "student_evaluation/index/$1";
$route['student_evaluation/student_program/(:any)/(:any)']	= "student_evaluation/student_program/$1/$2";
$route['student_evaluation/student/(:any)']	= "student_evaluation/student/$1";



$route['default_controller'] = 'site/login';

$route['logout'] = 'site/logout';
$route['login'] = 'site/login';

$route['site/user/admin'] = 'site/user_admin';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



$route['college/Page/(:num)'] = "college/index/$1";
$route['college/Page'] = "college/index";
$route['college/(:num)'] = "college/index/$1";
$route['college'] = "college/index";

$route['curriculum/Page/(:num)'] = "curriculum/index/$1";
$route['curriculum/Page'] = "curriculum/index";
$route['curriculum/(:num)'] = "curriculum/index/$1";
$route['curriculum'] = "curriculum/index";

$route['program/Page/(:num)'] = "program/index/$1";
$route['program/Page'] = "program/index";
$route['program/(:num)'] = "program/index/$1";
$route['program'] = "program/index";

$route['major/Page/(:num)'] = "major/index/$1";
$route['major/Page'] = "major/index";
$route['major/(:num)'] = "major/index/$1";
$route['major'] = "major/index";


$route['permanent_record/(:any)'] = "permanent_record/index/$1";

$route['tor/(:any)'] = "tor/index/$1";

$route['completion/(:any)'] = "completion/index/$1";

$route['leave_of_absence/(:any)'] = "leave_of_absence/index/$1";

$route['honorable_dismissal/(:any)'] = "honorable_dismissal/index/$1";

$route['withdraw_credentials/(:any)'] = "withdraw_credentials/index/$1";

