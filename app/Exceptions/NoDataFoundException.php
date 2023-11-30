<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception class for when no data is found.
 */
class NoDataFoundException extends Exception
{
   /**
    * Constructor for NoDataFoundException.
    *
    * @param string     $message  The exception message.
    * @param int        $code     The exception code.
    * @param Exception  $previous The previous exception.
    */
   public function __construct($message = 'Resource not found', $code = 404, Exception $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }

   /**
    * Convert the exception to a string representation.
    *
    * @return string The string representation of the exception.
    */
   public function __toString()
   {
       return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
   }
}