<?php

class Code {
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $creationDate;

    /**
     * @return DateTime
     */
    public function getDate() {
        return new DateTime($this->creationDate);
    }
}