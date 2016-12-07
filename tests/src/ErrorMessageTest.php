<?php
/**
 * ErrorMessageTest
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

use Resty\ErrorMessage;
/**
 * ErrorMessageTest
 *
 * @category  Resty
 * @package   Resty\Test
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class ErrorMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testea método addMeta
     * 
     * @return void
     */
    public function testAddMeta()
    {
        $expectedKeys = ["key1", "key2"];
        $expectedValues = ["value1", "value2"];
        $error = new ErrorMessage();
        $error->addMeta($expectedKeys[0], $expectedValues[0])
            ->addMeta($expectedKeys[1], $expectedValues[1]);

        $this->assertAttributeEquals(
            array_combine($expectedKeys, $expectedValues), 
            "meta", 
            $error
        );
    }

    /**
     * Testea el método append
     * 
     * @return void
     */
    public function testAppend()
    {
        $expectedKeys = ['title', 'details', 'status', 'code'];
        $expectedValues = [
            ["mytitle1", "mydetails1", 404, 1, []],
            ["mytitle2", "mydetails2", 500, 1, ["mymsg" => "mi error"]],
        ];

        $error = new ErrorMessage();
        $error->append(
            $expectedValues[0][0],
            $expectedValues[0][1],
            $expectedValues[0][2],
            $expectedValues[0][3],
            $expectedValues[0][4]
        )->append(
            $expectedValues[1][0],
            $expectedValues[1][1],
            $expectedValues[1][2],
            $expectedValues[1][3],
            $expectedValues[1][4]
        );

        $expected = [];
        $expected[0] = [
            'title' => $expectedValues[0][0],
            'details' => $expectedValues[0][1],
            'status' => $expectedValues[0][2],
            'code' => $expectedValues[0][3]
        ];
        $expected[1] = [
            'title' => $expectedValues[1][0],
            'details' => $expectedValues[1][1],
            'status' => $expectedValues[1][2],
            'code' => $expectedValues[1][3]
        ] + $expectedValues[1][4];

        $this->assertAttributeEquals(
            $expected,
            "errors",
            $error
        );
    }
    /**
     * Testea el método render
     * 
     * @return void
     */
    public function testRender()
    {
        $error = new ErrorMessage();
        $error->append("mytitle1", "mydetails1", 404, 1);

        $ref = new \ReflectionMethod('\Resty\ErrorMessage', 'render');
        $ref->setAccessible(true);
        $r = $ref->invoke($error);

        $expected = [
            'errors' => [
                [
                    'title' => 'mytitle1',
                    'details' => 'mydetails1',
                    'status' => 404,
                    'code' => 1
                ]
            ]
        ];
        $this->assertEquals($expected, $r);
    }
    
    /**
     * Testea el método render
     *
     * @depends testAppend
     * @depends testAddMeta
     * 
     * @return void
     */
    public function testRenderWithMeta()
    {
        $error = new ErrorMessage();
        $error->append("mytitle1", "mydetails1", 404, 1);
        $error->addMeta("myMetaKey", "myMetaValue");

        $ref = new \ReflectionMethod('\Resty\ErrorMessage', 'render');
        $ref->setAccessible(true);
        $r = $ref->invoke($error);

        $expected = [
            'myMetaKey' => 'myMetaValue',
            'errors' => [
                [
                    'title' => 'mytitle1',
                    'details' => 'mydetails1',
                    'status' => 404,
                    'code' => 1
                ]
            ]
        ];
        $this->assertEquals($expected, $r);
    }
    /**
     * Testea el método jsonSerialize
     *
     * @depends testRender
     * 
     * @return void
     */
    public function testJsonSerialize()
    {
        $error = new ErrorMessage();
        $error->append("mytitle1", "mydetails1", 404, 1);

        $expected = [
            'errors' => [
                [
                    'title' => 'mytitle1',
                    'details' => 'mydetails1',
                    'code' => 1,
                    'status' => 404
                ]
            ]
        ];

        $this->assertEquals(
            json_encode($expected), 
            json_encode($error)
        );
    }
}
