<?php
/**
 * Created by PhpStorm.
 * User: smekkaoui
 * Date: 28/08/2015
 * Time: 16:41
 */
namespace Framework;

class Logger {

    const LOG_LEVEL_ALERT = 0;
    const LOG_LEVEL_WARNING = 1;
    const LOG_LEVEL_DEBUG = 2;

    const LOG_TAG_ALERT   = 'ALERT';
    const LOG_TAG_WARNING = ' WARN';
    const LOG_TAG_DEBUG   = 'DEBUG';
    /**
     * @var String
     */
    private $fileName;

    /**
     * @var resource
     */
    private $handler;

    /** @var int */
    private $logLevel;


    /**
     * @param string $fileName
     * @param integer $logLevel
     * @throws \Exception
     */
    public function __construct($fileName, $logLevel = 2) {
        $this->fileName = $fileName;
        $this->handler = fopen($fileName, "a");
        if(!file_exists($fileName)) {
            throw new \Exception("Unable to Open File for logging : ".$fileName);
        }

        if (!$this->handler) {
           throw new \Exception("Can't create or open the logging file. Change files chmod");
        }

        $this->logLevel = $logLevel;
    }


    public function __destruct() {
        fclose($this->handler);
    }

    /**
     * @param $string
     */
    private function output($string, $level = "")
    {
        $dateTime = new \DateTime();
        $dateString = $dateTime->format("[Y/m/d H:m:s]");
        $fullString = sprintf('%1$s [%4$s] %2$s %3$s', $dateString, $string, "\n", $level);
        fwrite($this->handler, $fullString);
    }


    public function debug($string)
    {
        if (2 > $this->logLevel) {
            return null;
        }
        $this->output($string, self::LOG_TAG_DEBUG);
    }

    public function warning($string)
    {
        if (1 > $this->logLevel)
        {
            return null;
        }

        $this->output($string, self::LOG_TAG_WARNING);
    }
    public function alert($string) {
        $this->output($string, self::LOG_TAG_ALERT);
    }
}