<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Class RequestProtocolFilter
 *
 * This filter checks if the request is using a secure protocol (HTTPS).
 * If the request is not secure, it returns an unauthorized response with an error message.
 */
class RequestProtocolFilter implements FilterInterface
{
    /**
     * Runs before the controller action is executed.
     *
     * @param RequestInterface $request The request object.
     * @param mixed $arguments Additional arguments passed to the filter.
     *
     * @return ResponseInterface|null Returns a response object if the request is not secure, otherwise null.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request->isSecure()) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            $response->setJSON([
                'status' => 'error',
                'msg' => 'HTTPS required'
            ]);
            $response->sendHeaders();
            return $response;
        }
    }

    /**
     * Runs after the controller action is executed.
     *
     * @param RequestInterface $request The request object.
     * @param ResponseInterface $response The response object.
     * @param mixed $arguments Additional arguments passed to the filter.
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No actions needed after the request is executed.
    }
}
