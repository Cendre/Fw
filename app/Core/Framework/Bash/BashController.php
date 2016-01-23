<?php
namespace Framework\Bash;

use Framework\Bash\OdeBash;
use Framework\Logger;

class BashController
{
    /** @var Logger $logger */
    private $logger;

    /** @var string  */
    private $bashTag = ".: Cendre :. > ";

    /** @var resource $in */
    private $in;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->commandManager = new OdeBash();

        $this->in = fopen('php://stdin', 'r');
    }

    public function init()
    {
        $this->prompt();
    }

    private function prompt()
    {
        echo ($this->getBash());

        $get = fgets($this->in);
        $get = str_replace("\n","",$get);
        $get = str_replace("\r","",$get);
        try {
            echo $this->getCommand($get);
        } catch (CommandNotFoundException $e) {
            $this->out('Commande '.$get.' inconnue');
        } catch (\Exception $e) {
            $this->out($e->getMessage());
        }

        $this->prompt();
    }

    private function getBash()
    {
        return $this->bashTag;
    }

    private function getCommand($get)
    {
        if(!method_exists($this->commandManager, $get)) {
            throw new CommandNotFoundException();
        }

        return $this->commandManager->$get()."\n";
    }

    private function out($string)
    {
        echo $string."\n";
    }
}
