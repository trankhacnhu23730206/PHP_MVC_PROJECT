<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'demo_php');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root (Dynamic)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = dirname(dirname($script_name));
// Ensure base_path is not just '/' or '\' for root domains, otherwise rtrim might remove the only slash.
$base_path = ($base_path === '/' || $base_path === '\\') ? '' : $base_path;

// Dynamically replace the base path if it's incorrect
$base_path = str_replace('demoPHP', 'PHP_MVC_PROJECT', $base_path);

define('URLROOT', $protocol . '://' . $host . $base_path);
// Site Name
define('SITENAME', 'PHP_MVC_PROJECT');

