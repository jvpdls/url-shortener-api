<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Class APIAuthFilter
 *
 * This class is responsible for authenticating API requests based on the provided API key.
 */
class APIAuthFilter implements FilterInterface
{
    /**
     * Performs authentication before the request is executed.
     *
     * @param RequestInterface $request The request object.
     * @param mixed|null $arguments Additional arguments passed to the filter.
     *
     * @return ResponseInterface|null The response object if authentication fails, null otherwise.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = $request->getHeaderLine('API-Key');
        
        if ($key != getenv('API_KEY')) {
            $response = service('response');
            $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            $response->setJSON([
                'status' => 'error',
                'msg' => 'Invalid API key'
            ]);
            $response->sendHeaders();
            return $response;
        }
    }

    /**
     * Performs actions after the request is executed.
     *
     * @param RequestInterface $request The request object.
     * @param ResponseInterface $response The response object.
     * @param mixed|null $arguments Additional arguments passed to the filter.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No actions needed after the request is executed.
    }
}
