<?php
/**
 * Created by PhpStorm.
 * User: smekkaoui
 * Date: 28/08/2015
 * Time: 16:41
 */
namespace Framework;

class Logger {

    /**
     * @var String
     */
    private $fileName;

    /**
     * @var resource
     */
    private $handler;

    /**
     * @param string $fileName
     * @throws \Exception
     */
    public function __construct($fileName) {
        $this->fileName = $fileName;
        $this->handler = fopen($fileName, "a");
        if(!file_exists($fileName)) {
            throw new \Exception("Unable to Open File for logging : ".$fileName);
        }

        if (!$this->handler) {
           throw new \Exception("Can't create or open the logging file. Change files chmod");
        }
    }


    public function __destruct() {
        fclose($this->handler);
    }

    /**
     * @param $string
     */
    public function debug($string) {
        $dateTime = new \DateTime();
        $dateString = $dateTime->format("[Y/m/d H:m:s]");
        $fullString = sprintf('%1$s %2$s %3$s', $dateString, $string, "\n");
        fwrite($this->handler, $fullString);
    }
}