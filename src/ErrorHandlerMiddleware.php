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
namespace Resty;
// Resty
use Resty\Handler\PhpError;
use Resty\Handler\Error;
use Resty\Handler\NotFound;
use Resty\Handler\NotAllowed;
// Slim
use Slim\Container;
// PSR
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

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
        $this->container['errorHandler'] = function ($container) {
            return new Error($container->get('settings')['displayErrorDetails']);
        };
        $this->container['phpErrorHandler'] = function ($container) {
            return new PhpError($container->get('settings')['displayErrorDetails']);
        };
        $this->container['notFoundHandler'] = function ($container) {
            return new NotFound($container->get('settings')['displayErrorDetails']);
        };
        $this->container['notAllowedHandler'] = function ($container) {
            return new NotAllowed($container->get('settings')['displayErrorDetails']);
        };

        $response = $next($request, $response);

        return $response;
    }
}
