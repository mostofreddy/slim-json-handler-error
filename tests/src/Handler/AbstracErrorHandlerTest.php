<?php
/**
 * AbstracErrorHandlerTest
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
namespace Resty\Slim\Test;

use Resty\Slim\Handler\Error;
use Slim\Http\Response;
/**
 * AbstracErrorHandlerTest
 *
 * @category  Resty
 * @package   Resty\Test
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class AbstracErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $object;
    protected $param = ["saludo" => 'hola'];
    /**
     * Testea metodo response
     * 
     * @return void
     */
    public function testResponse()
    {
        $error = new Error(false);

        $param = json_encode($this->param);

        $ref = new \ReflectionMethod('\Resty\Slim\Handler\Error', 'response');
        $ref->setAccessible(true);
        $object = $ref->invokeArgs($error, [new Response, $param]);

        $this->assertInstanceOf(
            '\Slim\Http\Response',
            $object
        );
    }
    /**
     * Testea que el status se configure bien
     * 
     * @return void
     */
    public function testStatus()
    {
        $error = new Error(false);

        $param = json_encode($this->param);

        $ref = new \ReflectionMethod('\Resty\Slim\Handler\Error', 'response');
        $ref->setAccessible(true);
        $object = $ref->invokeArgs($error, [new Response, $param]);

        $this->assertAttributeEquals(500, 'status', $object);
    }
    /**
     * Testea que los headers queden bien configurados
     * 
     * @return void
     */
    public function testHeaders()
    {
        $error = new Error(false);

        $param = json_encode($this->param);

        $ref = new \ReflectionMethod('\Resty\Slim\Handler\Error', 'response');
        $ref->setAccessible(true);
        $object = $ref->invokeArgs($error, [new Response, $param]);

        $this->assertEquals(
            ['Content-Type' => ['application/json;charset=utf-8']],
            $object->getHeaders()
        );
    }

    /**
     * Testea el constructor
     * 
     * @return void
     */
    public function testConstruct()
    {
        $error = new Error(false);
        $this->assertAttributeEquals(false, 'displayErrorDetails', $error);
    }
}
