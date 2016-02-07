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
        $desc = ["List of all avaible commands :"];

        foreach ($methods as $method) {

            if (strpos($method, "Help") || strpos($method, "help") || in_array($method,$this->getInvisibleCommands())) {
                continue;
            }


            $description = " - ".$method;

            if(method_exists($this, $method . "Help")) {
                $methodName = $method."Help";
                $description .= " : \n\t".$this->$methodName();
            }

            $desc[] = $description;
        }
        return implode("\n\n", $desc);
    }

    public function helpHelp()
    {
        return "Display this help :)";
    }

    public function getPromptString() {
        return static::BASH_STRING;
    }

    public function initialize()
    {

    }

    private function getInvisibleCommands()
    {
        return [
            "initialize",
            "getPromptString",
            "getInvisibleCommands"
        ];
    }
}