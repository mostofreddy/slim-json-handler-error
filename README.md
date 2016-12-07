Slim Json Error Handler
======================

[![Build Status](https://travis-ci.org/mostofreddy/slim-json-handler-error.svg?branch=master)](https://travis-ci.org/mostofreddy/slim-json-handler-error)

Handlers de errores para Slim que siempre devuelven los errores en formato JSON utilizando el estandar de JSON-API.

Este middleware esta pensado para ser utilizado cuando se desarrollan apis Restfull que devuelven siempre formato JSON

Versión estable
---------------

0.1.1

License
-------

The MIT License (MIT). Ver el archivo [LICENSE](LICENSE.md) para más información

Descripción
------------

Slim posee cuantro handlers para manejar distintos tipos de error

* Errores de PHP (PhpError)
* Ruta no encontrada (NotFound)
* Método HTTP incorrecto (NotAllowed)
* Captura de excepciones de usuario (Error)

Cada uno de ellos devuelve el error en el formato que sea solicitado por a cabecera Content-type (hmtl, json, etc). Este middleware reescribe estos handlers para que siempre devuelvan formato JSON.

__Formato de respuesta__

Para unificar el formato de respuesta se siguió el estandar de [JsonApi](http://jsonapi.org/format/#error-objects)

### Ejemplo

```
{
  "errors": [
    {
      "title": "Resty Application Error",
      "details": "",
      "code": 0,
      "status": 500
    }
  ]
}
```

Donde:

| key | Descripción |
|---|---|
| title | Título del error |
| details | Detalles del error (solo es devuelto cuando el parametro `displayErrorDetails` tiene como valor `true`) |
| code | Código propio del error |
| status | HTTP CODE del error |

### Configuración de Slim

```
// para Desarrollo / QA
$config['settings'] = [
    "displayErrorDetails" => true
];

// para Producción
$config['settings'] = [
    "displayErrorDetails" => false
];
```

Handlers
--------

### Errores de PHP

Clase: `\Resty\Handler\PhpError`

```
{
  "errors": [
    {
      "title": "Resty Application Error",
      "details": "",
      "code": 0,
      "status": 500
    }
  ]
}
```

### Ruta no encontrada

Clase: `\Resty\Handler\NotFound`

```
{
  "errors": [
    {
      "title": "Page not found",
      "details": "Request => GET:http://localhost:5005/hola",
      "code": 0,
      "status": 404
    }
  ]
}
```

### Método HTTP incorrecto

Clase: `\Resty\Handler\NotAllowed`

```
{
  "errors": [
    {
      "title": "Method not allowed",
      "details": "Request => POST:http://localhost:5005/. Method not allowed. Must be one of GET",
      "code": 0,
      "status": 405
    }
  ]
}
```

### Captura de excepciones de usuario

Clase: `\Resty\Handler\Error`

```
{
  "errors": [
    {
      "title": "Resty Application Error",
      "details": [
        {
          "type": "MyException",
          "code": 12312,
          "message": "Mi mensaje de error"
        }
      ],
      "code": 0,
      "status": 501
    }
  ]
}
```


## Ejemplos de uso

### Configurar middleware para todas las rutas

```
require_once "../vendor/autoload.php";

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$config = [];
$config['settings'] = [
    "displayErrorDetails" => true, // or false
    "determineRouteBeforeAppMiddleware" => true
];

$api = new App($config);

$api->add('\Resty\ErrorHandlerMiddleware');

$api->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $body = $response->getBody();
    $body->write('Hello');
    return $response;
});
$api->run();
```

### Configurar middleware para alguna ruta (o grupo) en particular

```
require_once "../vendor/autoload.php";

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$config = [];
$config['settings'] = [
    "displayErrorDetails" => true, // or false
    "determineRouteBeforeAppMiddleware" => true
];

$api = new App($config);

$api->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    $body = $response->getBody();
    $body->write('Hello');
    return $response;
})->add('\Resty\ErrorHandlerMiddleware');;
$api->run();
```
