<?php
require_once "./app/init.php";
require_once "./vendor/autoload.php";
require_once "./app/autoloader.php";


$logger = new \Framework\Logger('logs/console', \Framework\Logger::LOG_LEVEL_DEBUG);
$bash = new \Framework\Bash\Prompt($logger);

$bash->init();