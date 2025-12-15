<?php

// Root directory of your project
define('ROOT', __DIR__.'/');

// Application subdirectories
define('SRC', ROOT.'src/');
define('CONFIG', ROOT.'config/');
define('PAGES', SRC.'Views/pages/');
define('LAYOUTS', SRC.'Views/layouts/');
define('CONTROLLERS', SRC.'Controllers/');
define('ASSETS', ROOT.'public/assets/');
define('VENDOR', ROOT.'vendor/');

// Dynamic BASE_URL for redirects, links, assets (handles subfolder like /jobjet_new/public/)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
define('BASE_URL', $protocol.$_SERVER['HTTP_HOST'].$base.'/');
