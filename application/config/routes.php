<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'index';
$route['404_override'] = 'beranda/notfound';
$route['translate_uri_dashes'] = FALSE;

// Landing
$route['notfound']                = 'beranda/notfound';
$route['search']                  = 'beranda/search/';
$route['legal/(:any)']            = 'beranda/legal/$1';
$route['post/detail/(:any)']      = 'beranda/detail/$1';
$route['tag/(:any)']              = 'beranda/tag/$1';
$route['tag']                     = 'beranda/tag_all';
$route['kategori/(:any)']         = 'beranda/kategori/$1';
$route['kategori']                = 'beranda/kategori_all';
$route['beranda/page/(:any)']     = 'beranda/index/$1';
$route['showpost']                = 'beranda/post_by_id';
$route['kirim_komentar']          = 'beranda/add_comment';
$route['kirim_pesan']             = 'beranda/pesan';
$route['forgot']                  = 'auth/forgot';
$route['reset']                   = 'auth/reset';
$route['send']                    = 'auth/send';
$route['active']                  = 'auth/active';
$route['block']                   = 'auth/block';

// Admin
$route['admin/comment']           = 'admin/comment/show/publik';
$route['admin/comment/update']    = 'admin/comment/edit';
$route['admin/comment/(:any)']    = 'admin/comment/show/$1';
$route['admin/post/get-edit/(:any)']  = 'admin/post/get_edit/$1';
$route['admin/database']          = 'admin/website';
