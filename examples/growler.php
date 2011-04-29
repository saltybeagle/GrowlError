<?php
set_include_path(__DIR__ . '/../src' . PATH_SEPARATOR . __DIR__ . '/../vendor/php');
ini_set('display_errors', true);
require_once 'GrowlError.php';
require_once 'Net/Growl.php';
$growler = new GrowlError();

echo $foo;