<?php
/**
 * AbstracErrorHandler
 *
 * PHP version 7+
 *
 * Copyright (c) 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Resty
 * @package   Resty\Handler
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Resty\Slim\Handler;

// Slim
use Psr\Http\Message\ResponseInterface;

/**
 * AbstracErrorHandler
 *
 * @category  Resty
 * @package   Resty\Handler
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
abstract class AbstracErrorHandler
{
    const HTTP_STATUS = 500;

    protected $displayErrorDetails;

    /**
     * Constructor
     *
     * @param bool $displayErrorDetails Set to true to display full details
     */
    public function __construct($displayErrorDetails = false)
    {
        $this->displayErrorDetails = (bool) $displayErrorDetails;
    }
    /**
     * Transforma la respuesta en json
     * 
     * @param ResponseInterface $response Instancia de ResponseInterface
     * @param mixed             $output   String de respuesta en formato JSON
     * 
     * @return ResponseInterface
     */
    protected function response(ResponseInterface $response, $output):ResponseInterface
    {
        return $response->withJson($output, static::HTTP_STATUS);
    }
}
