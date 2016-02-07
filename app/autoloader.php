<?php
define("CORE_DIR", __DIR__."/Core/");
define("BASE_DIR", __DIR__."/../");

function FwAutoload($classname)
{
    $translated_path = str_replace('\\', '/', $classname);
    $fullPath = CORE_DIR.$translated_path.".php";
    require_once $fullPath;
}

spl_autoload_register('FwAutoload');
