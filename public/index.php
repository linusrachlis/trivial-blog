<?php

use app\actions\Index;
use lib\Action;

require_once __DIR__ . '/../bootstrap.php';

$actionClass = empty($_GET['action']) ? Index::class : $_GET['action'];

if (
    // Make sure requested action exists...
    !class_exists($actionClass) ||
    // ... is an 'Action' ...
    !in_array(Action::class, class_implements($actionClass)) ||
    // ... and is found in the expected Actions namespace.
    0 !== strpos($actionClass, 'app\\actions\\')
) {
    // Should make a NotFound action for this purpose
    header('HTTP/1.1 404 Not Found');
    exit("Action class not found: " . var_export($actionClass, true));
}

$method = strtolower($_SERVER['REQUEST_METHOD']);

/** @var Action $actionClass */
$actionClass::$method();
