<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Production Database Configuration
| This file is loaded when CI_ENVIRONMENT is set to 'production'
*/

$active_group = 'default';
$query_builder = TRUE;

// Parse DATABASE_URL environment variable (for PostgreSQL)
$db_url = parse_url(getenv('DATABASE_URL'));

$db['default'] = array(
    'dsn'      => '',
    'hostname' => $db_url['host'] ?? 'localhost',
    'username' => $db_url['user'] ?? 'root',
    'password' => $db_url['pass'] ?? '',
    'database' => ltrim($db_url['path'] ?? '', '/'),
    'dbdriver' => 'postgre', // Render uses PostgreSQL
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port'     => $db_url['port'] ?? 5432
);

// Fallback for local development
if (!getenv('DATABASE_URL')) {
    $db['default'] = array(
        'dsn'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'your_local_database',
        'dbdriver' => 'mysqli',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt'  => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
    );
}