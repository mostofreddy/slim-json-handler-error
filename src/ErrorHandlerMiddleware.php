<?php
/**
 * ErrorHandlerMiddleware
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Interfaces
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Slim;
// Resty
use Resty\Slim\DefaultJsonResponse;
// Slim
use Slim\Container;
/**
 * ErrorHandlerMiddleware
 *
 * @category  Resty
 * @package   Resty\Interfaces
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ErrorHandlerMiddleware
{
    protected $container;
    /**
     * Contructor
     * 
     * @param Container $container Instancia de Container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    /**
     * Middleware
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        // Redefine - errors
        $this->container['errorHandler'] = DefaultJsonResponse::jsonError();
        $this->container['phpErrorHandler'] = DefaultJsonResponse::jsonPhpError();
        $this->container['notFoundHandler'] = DefaultJsonResponse::jsonNotFound();
        $this->container['notAllowedHandler'] = DefaultJsonResponse::jsonNotAllowed();

        $response = $next($request, $response);
        return $response;
    }
}
