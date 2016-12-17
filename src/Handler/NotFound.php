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
use Resty\Slim\ErrorMessage;
// PSR
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
class NotFound extends AbstracErrorHandler
{
    const HTTP_STATUS = 404;

    /**
     * Invoca la respuesta
     * 
     * @param ServerRequestInterface $request  Instancia de ServerRequestInterface
     * @param ResponseInterface      $response Instancia de ResponseInterface
     * 
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->response(
            $response,
            $this->render($request)
        );
    }
    /**
     * Renderiza el mensaje de error
     * 
     * @param ServerRequestInterface $request Instancia de Request
     * 
     * @return string
     */
    protected function render(ServerRequestInterface $request) 
    {
        $message = new ErrorMessage();
        $message->append(
            'Page not found',
            'Request => '.$request->getMethod().":".$request->getUri()->__toString(),
            static::HTTP_STATUS
        );
        return json_encode($message, JSON_PRETTY_PRINT);
    }
}
