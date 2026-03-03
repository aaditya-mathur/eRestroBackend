<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'quatafood_admin',
	'password' => 'QuotaFood2026@',
	'database' => 'quatafood_db',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

// Override for the development/cPanel environment
if (isset($_SERVER['HTTP_HOST'])) {
    if (strpos($_SERVER['HTTP_HOST'], 'api.ppdev.in') !== false || strpos($_SERVER['HTTP_HOST'], 'aajastharetail.com') !== false) {
        $db['default']['hostname'] = '89.116.32.183';
        $db['default']['username'] = 'aajastharetail_eRestroUser';
        $db['default']['password'] = 'eRestro#1810';
        $db['default']['database'] = 'aajastharetail_eRestro';
    }
}
