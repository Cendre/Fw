<?php
/**
 * Created by PhpStorm.
 * User: haniel
 * Date: 22/01/16
 * Time: 21:22
 */

namespace Framework\Bash;

abstract class AbstractCommandManager {
    const BASH_STRING = "Bash > ";

    public function quit()
    {
        exit("Goodbye");
    }

    public function quitHelp()
    {
        return "To quit";
    }

    public function help() {

        $methods = get_class_methods($this);
        $desc = [];

        foreach ($methods as $method) {

            if (strpos($method, "Help") || strpos($method, "help")) {
                continue;
            }


            $description = "* ".$method;

            if(method_exists($this, $method . "Help")) {
                $methodName = $method."Help";
                $description .= " : ".$this->$methodName();
            }

            $desc[] = $description;
        }

        return implode("\n", $desc);
    }

    public function getPromptString() {
        return static::BASH_STRING;
    }
}