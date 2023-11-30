<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception class for when body parameters are missing.
 */
class ParamsMissingException extends Exception
{
   /**
    * Constructor for ParamsMissingException.
    *
    * @param string     $message  The exception message.
    * @param int        $code     The exception code.
    * @param Exception  $previous The previous exception used for chaining.
    */
   public function __construct($message = 'Body params are missing.', $code = 400, Exception $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }

   /**
    * Convert the exception to a string representation.
    *
    * @return string
    */
   public function __toString()
   {
       return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
   }
}