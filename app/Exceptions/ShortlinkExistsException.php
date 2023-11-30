<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception class for ShortlinkExistsException.
 *
 * This exception is thrown when a shortlink already exists in the system.
 */
class ShortlinkExistsException extends Exception
{
   /**
    * Constructor for ShortlinkExistsException.
    *
    * @param string     $message  The exception message.
    * @param int        $code     The exception code.
    * @param Exception  $previous The previous exception used for chaining.
    */
   public function __construct($message = 'Shortlink already in use. Try with another slug', $code = 400, Exception $previous = null)
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