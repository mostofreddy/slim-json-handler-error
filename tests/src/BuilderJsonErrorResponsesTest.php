<?php
/**
 * BuilderJsonErrorResponsesTest
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
// PHPUnit
use PHPUnit\Framework\TestCase;
// Slim
use Slim\Container;
// Resty
use Resty\Slim\BuilderJsonErrorResponses;
/**
 * BuilderJsonErrorResponsesTest
 *
 * @category  Resty
 * @package   Resty\Test
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class BuilderJsonErrorResponsesTest extends TestCase
{
    /**
     * Testea metodo jsonPhpError
     * 
     * @return void
     */
    public function testJsonPhpError()
    {
        $closure = BuilderJsonErrorResponses::jsonPhpError();
        $r = $closure(new Container);
        $this->assertInstanceOf('\Resty\Slim\Handler\Error', $r);
    }
    /**
     * Testea metodo jsonError
     * 
     * @return void
     */
    public function testJsonError()
    {
        $closure = BuilderJsonErrorResponses::jsonError();
        $r = $closure(new Container);
        $this->assertInstanceOf('\Resty\Slim\Handler\Error', $r);
    }
    /**
     * Testea metodo jsonNotFound
     * 
     * @return void
     */
    public function testJsonNotFound()
    {
        $closure = BuilderJsonErrorResponses::jsonNotFound();
        $r = $closure(new Container);
        $this->assertInstanceOf('\Resty\Slim\Handler\NotFound', $r);
    }
    /**
     * Testea metodo jsonNotAllowed
     * 
     * @return void
     */
    public function testJsonNotAllowed()
    {
        $closure = BuilderJsonErrorResponses::jsonNotAllowed();
        $r = $closure(new Container);
        $this->assertInstanceOf('\Resty\Slim\Handler\NotAllowed', $r);
    }
}
