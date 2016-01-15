<?php
define("CORE_DIR", __DIR__."/Core/");

function FwAutoload($classname)
{
    $translated_path = str_replace('\\', '/', $classname);
    $fullPath = CORE_DIR.$translated_path.".php";
    require_once $fullPath;
}

spl_autoload_register('FwAutoload');
