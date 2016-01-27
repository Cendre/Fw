<?php
/**
 * Created by PhpStorm.
 * User: haniel
 * Date: 25/01/16
 * Time: 20:06
 */
namespace TestProject;

use Framework\Bash\AbstractCommandManager;


class TestCommandManager extends AbstractCommandManager {
    const BASH_STRING = "Test >>>> ";

    public function lol() {
        return "lol";
    }
}