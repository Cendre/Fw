<?php
namespace Framework\Bash;

use Framework\Logger;

class Prompt
{
    /** @var Logger $logger */
    private $logger;

    /** @var resource $in */
    private $in;

    /**
     * @var \StdClass
     */
    private $parameters;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->commandManager = new CendreCommandManager();
        $this->parameters = $this->getconfig();
        $this->in = fopen('php://stdin', 'r');
    }

    public function init()
    {
        $this->prompt();
    }

    private function prompt()
    {
        echo ($this->commandManager->getPromptString());

        $get = fgets($this->in);
        $get = str_replace("\n","",$get);
        $get = str_replace("\r","",$get);
        $params = explode(" ", $get);

        try {
            $this->out($this->getCommand($params[0], $params));
        } catch (CommandNotFoundException $e) {
            $this->out('Commande '.$get.' inconnue');
        } catch (\Exception $e) {
            $this->out($e->getMessage());
            $this->logger->warning($e->getMessage());
        }

        $this->prompt();
    }

    private function getCommand($get, Array $params = [])
    {
        if ("setmanager" === $get) {
            return $this->setManager($params[1]);
        }

        if ("listmanager" === $get) {
            return $this->listManager();
        }

        if (!method_exists($this->commandManager, $get)) {
            throw new CommandNotFoundException();
        }

        return $this->commandManager->$get();
    }

    private function out($string)
    {
        echo $string."\n";
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function setManager($managerName)
    {
        if(!$this->parameters->commands->$managerName) {
            throw new \Exception("Unknown manager ".$managerName);
        }
        $class = $this->parameters->commands->$managerName;
        $this->commandManager = new $class();
        $this->commandManager->initialize();
    }

    private function listManager()
    {
        $names = [];
        foreach($this->parameters->commands as $name => $command) {
            $names[] = $name;
        }

        return implode("\n\r", $names);
    }

    private function getconfig() {
        $rawConfig = file_get_contents(CORE_DIR."../parameters.json");
        $config = json_decode($rawConfig);

        return $config;
    }
}
