<?php

namespace App\Helpers;

use Exception;

class ExceptionHandlerHelper
{
    /**
     * Handle the exception and return a JSON response.
     *
     * @param Exception $e The exception to be handled.
     * @return \Illuminate\Http\Response The JSON response.
     */
    public static function handleException(Exception $e)
    {
        $response = [
            'status' => 'error',
            'msg' => $e->getMessage()
        ];

        $statusCode = method_exists($e, 'getCode') ? $e->getCode() : 500;
        $statusCode == 0 ? $statusCode = 500 : $statusCode = $statusCode;

        return response()->setStatusCode($statusCode)->setJSON($response);
    }
}
