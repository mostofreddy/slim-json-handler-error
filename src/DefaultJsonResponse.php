<?php
/**
 * DefaultJsonResponse
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Slim
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Slim;
// Resty
use Resty\Slim\Handler\PhpError;
use Resty\Slim\Handler\Error;
use Resty\Slim\Handler\NotFound;
use Resty\Slim\Handler\NotAllowed;
// Slim
use Slim\Container;

/**
 * DefaultJsonResponse
 *
 * @category  Resty
 * @package   Resty\Slim
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class DefaultJsonResponse
{
    /**
     * Json PhpError
     * 
     * @return \Closure
     */
    public static function jsonPhpError():\Closure
    {
        return function (Container $container) {
            return new PhpError($container->get('settings')['displayErrorDetails']);
        };
    }

    /**
     * Json Error
     * 
     * @return \Closure
     */
    public static function jsonError():\Closure
    {
        return function (Container $container) {
            return new Error($container->get('settings')['displayErrorDetails']);
        };
    }

    /**
     * Json NotFound
     * 
     * @return \Closure
     */
    public static function jsonNotFound():\Closure
    {
        return function (Container $container) {
            return new NotFound($container->get('settings')['displayErrorDetails']);
        };
    }

    /**
     * Json NotAllowed
     * 
     * @return \Closure
     */
    public static function jsonNotAllowed():\Closure
    {
        return function (Container $container) {
            return new NotAllowed($container->get('settings')['displayErrorDetails']);
        };
    }
}
