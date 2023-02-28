<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'Auth/access';
$route['404_override'] = '';

$route['customer_pricing.php'] = 'ApiController/customer_pricing';
$route['csp_install_check.js'] = 'ApiController/csp_install_check';
$route['js/cspqb.js'] = 'ApiController/cspqb';
