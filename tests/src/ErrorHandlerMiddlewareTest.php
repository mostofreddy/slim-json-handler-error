<?php
/**
 * ErrorHandlerMiddlewareTest
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Test\Doctrine
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Test;

use Resty\ErrorHandlerMiddleware;
use Slim\Container;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use Slim\Http\Headers;
use Slim\Http\Body;

/**
 * ErrorHandlerMiddlewareTest
 *
 * @category  Resty
 * @package   Resty\Test
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ErrorHandlerMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testea el método __invoke
     * 
     * @return void
     */
    public function testInvoke()
    {
        $uri = Uri::createFromString('https://example.com:443/foo/bar?abc=123');
        $headers = new Headers();
        $cookies = [];
        $serverParams = [];
        $body = new Body(fopen('php://temp', 'r+'));

        $container = new Container();
        $errorHandler = new ErrorHandlerMiddleware($container);
        $errorHandler(
            new Request('GET', $uri, $headers, $cookies, $serverParams, $body), 
            new Response, 
            function () {
            }
        );

        $this->assertInstanceOf(
            'Resty\Handler\Error',
            $container['errorHandler']
        );

        $this->assertInstanceOf(
            'Resty\Handler\PhpError',
            $container['phpErrorHandler']
        );

        $this->assertInstanceOf(
            'Resty\Handler\NotFound',
            $container['notFoundHandler']
        );

        $this->assertInstanceOf(
            'Resty\Handler\NotAllowed',
            $container['notAllowedHandler']
        );
    }
}
