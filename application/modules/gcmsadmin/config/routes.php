<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



//eg : $route['404_override']  = "/error404";
$route['404_override'] = "gcmsadmin/error404";


$route['gcmsadmin/users/:num'] = "gcmsadmin/users/list_users";
