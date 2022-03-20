<?php

use Monolog\Logger;

require_once __DIR__ . '/../vendor/autoload.php';

session_name('pixel-canvas');
session_start();

// settings
define('DEBUG', true);
define('APP_NAME', 'pixel-canvas');

if (!empty($_REQUEST['session'])) {
    $action = $_REQUEST['session'];
    switch ($action) {
        case 'new':
            session_destroy();
            session_start();
            break;
    }
}
