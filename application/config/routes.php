<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['team/(:num)'] = "team/index/$1";
$route['rss/(:num)'] = "rss/index/$1";
$route['collection/(:num)'] = "collection/index/$1";
$route['item/(:num)'] = "item/index/$1";
$route['people/(:any)'] = "people/index/$1";
$route['user/(:num)'] = "user/index/$1";
$route['author/(:num)'] = "author/index/$1";
$route['g/(:any)'] = "group/index/$1";
$route['group/(:num)'] = "group/index/$1";
$route['group/(:num)/(:num)'] = "group/index/$1/$2";
$route['tool/featured/(:any)'] = "tool/featured/$1";
$route['tool/featured/(:any)/(:any)'] = "tool/featured/$1/$2";
$route['t/(:any)'] = "tool/index/$1";
$route['disk/(:num)'] = "disk/index/$1";
$route['folder/(:num)'] = "folder/index/$1";
$route['particle2dx'] = "item/particle2dx";
$route['tool/(:num)'] = "tool/index/$1";
$route['tool/(:num)/(:num)'] = "tool/index/$1/$2";
$route['folder/(:num)/(:num)'] = "folder/index/$1/$2";
$route['topic/(:num)'] = "topic/index/$1";
$route['topic/(:num)/(:num)'] = "topic/index/$1/$2";
$route['task/(:num)'] = "task/index/$1";
$route['task/(:num)/(:num)'] = "task/index/$1/$2";
$route['result/(:num)'] = "result/index/$1";
$route['default_controller'] = "home";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
