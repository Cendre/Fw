<?php

class EntityException extends Exception
{
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}