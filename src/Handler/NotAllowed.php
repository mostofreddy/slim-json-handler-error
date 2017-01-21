<?php
/**
 * NotFound
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
// Resty
use Resty\Slim\Handler\AbstracErrorHandler;
// PSR
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
// Hateoas
use Mostofreddy\Hateoas\ErrorMessage;

/**
 * NotFound
 *
 * @category  Resty
 * @package   Resty\Handler
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2016 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 *
 * @codeCoverageIgnore
 */
class NotAllowed extends AbstracErrorHandler
{
    const HTTP_STATUS = 405;

    /**
     * Invoca la respuesta
     * 
     * @param ServerRequestInterface $request  Instancia de ServerRequestInterface
     * @param ResponseInterface      $response Instancia de ResponseInterface
     * @param array                  $methods  Array de metodos http disponibles
     * 
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $methods = [])
    {
        return $this->response(
            $response,
            $this->render($request, $methods)
        );
    }
    /**
     * Renderiza el mensaje de error
     * 
     * @param ServerRequestInterface $request Instancia de Request
     * @param array                  $methods Array de metodos http disponibles
     * 
     * @return ErrorMessage
     */
    protected function render(ServerRequestInterface $request, array $methods):ErrorMessage
    {
        $message = new ErrorMessage();
        $message->addError(
            'Method not allowed',
            'Request => '.$request->getMethod().":".$request->getUri()->__toString()
            .'. Method not allowed. Must be one of '.implode(", ", $methods),
            static::HTTP_STATUS
        );

        return $message;
    }
}
