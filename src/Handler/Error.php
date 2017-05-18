<?php
/**
 * Error
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
// Resty - JsonApiError
use Resty\JsonApiError\Message;
/**
 * Error
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
class Error extends AbstracErrorHandler
{
    const TITLE = "Internal server error";

    /**
     * Invoca la respuesta
     * 
     * @param ServerRequestInterface $request  Instancia de ServerRequestInterface
     * @param ResponseInterface      $response Instancia de ResponseInterface
     * @param \Throwable             $error    Instancia de Throwable
     * 
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Throwable $error)
    {
        return $this->response(
            $response,
            $this->render($error)
        );
    }
    /**
     * Renderiza el mensaje de error
     * 
     * @param \Throwable $error Instancia de Throwable
     * 
     * @return Message
     */
    protected function render(\Throwable $error):Message
    {
        $message = new Message();
        $e = $message->add(static::TITLE, $error->getMessage())
            ->setStatus(static::HTTP_STATUS)
            ->setCode($error->getCode());

        if ($this->displayErrorDetails) {
            $e->setSource(
                [
                    'file' => $error->getFile(),
                    'line' => $error->getLine()
                ]
            )->setMeta(
                [
                    'trace' => explode("\n", $error->getTraceAsString())
                ]
            );
        }

        return $message;
    }
}
