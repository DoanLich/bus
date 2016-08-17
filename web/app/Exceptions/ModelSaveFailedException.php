<?php
/**
 * @Author: doanlich
 * @Date:   2016-07-27 10:11:24
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-07-27 10:20:20
 */
namespace App\Exceptions;

use Exception;

class ModelSaveFailedException extends Exception
{
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        $message = 'Model could not be saved';

        parent::__construct($message, $code, $previous);
    }
}