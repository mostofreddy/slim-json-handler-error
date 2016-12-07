<?php
/**
 * PhpError
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
namespace Resty\Handler;

// Resty
use Resty\Handler\AbstracErrorHandler;
use Resty\ErrorMessage;
// PSR
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * PhpError
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
class PhpError extends AbstracErrorHandler
{
    const HTTP_STATUS = 500;

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
     * @return string
     */
    protected function render(\Throwable $error)
    {
        $message = new ErrorMessage();

        $details = [];

        do {
            $aux = [
                'type' => get_class($error),
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];

            if ($this->displayErrorDetails) {
                $aux = $aux + [
                    'file' => $error->getFile(),
                    'line' => $error->getLine(),
                    'trace' => explode("\n", $error->getTraceAsString())
                ];
            }

            $details[] = $aux;
        } while ($error = $error->getPrevious());

        $message->append(
            'Resty Application Error',
            $details,
            static::HTTP_STATUS
        );

        return json_encode($message, JSON_PRETTY_PRINT);
    }
}
