<?php
defined('BASEPATH') || exit('No direct script access allowed');


$route['webrtc'] = 'Webrtc/index';

//users
$route['users/login'] = 'users/login';

$route['users/register'] = 'users/register';
$route['changePassword'] = 'users/change_password';


$route['documents/update'] = 'documents/update';
$route['documents/edit'] = 'documents/edit';
$route['mydocuments'] = 'documents/mydocuments';
$route['create'] = 'documents/addDocument';
//$route['documents/(:any)'] = 'documents/view/$1';
$route['documents'] = 'documents/index';


$route['default_controller'] = 'users/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

//clients
$route['clients'] = 'ClientController/clientsTable';
$route['NewClient'] = 'ClientController/registerClient';

//contact
$route['contact'] = 'contact/contactEmail';


//calendar
$route['calendar'] = 'calendar/index';


