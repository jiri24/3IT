<?php

use app\controllers\App;
use app\controllers\Tabulka;
use Tracy\Debugger;

require_once '../vendor/autoload.php';

Debugger::enable(Debugger::PRODUCTION, __DIR__ .'/../zeta/logs/');

require_once '../app/DbConfig.php';
require_once '../app/Latte.php';

$urlPath = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');
$className = $urlPath ? 'app\\controllers\\' . ucfirst($urlPath) : Tabulka::class;

if (!class_exists($className) || !is_a($className, App::class, true)) {
   $className = Tabulka::class;
}

$app = new $className();

try {
   $app->run();
} catch (Throwable $e) {
   bdump($e->getMessage());
   echo $e->getMessage();
}
