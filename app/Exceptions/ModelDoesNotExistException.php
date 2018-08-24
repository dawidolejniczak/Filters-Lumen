<?php

namespace App\Exceptions;


final class ModelDoesNotExistException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Models does not exist.', 400);
    }
}