**Deprecated**

Slim Json Error Handler
======================

[![Build Status](https://travis-ci.org/mostofreddy/slim-json-handler-error.svg?branch=master)](https://travis-ci.org/mostofreddy/slim-json-handler-error)
[![Latest Stable Version](https://poser.pugx.org/restyphp/slim-json-handler-error/v/stable)](https://packagist.org/packages/restyphp/slim-json-handler-error)
[![License](https://poser.pugx.org/restyphp/slim-json-handler-error/license)](https://packagist.org/packages/restyphp/slim-json-handler-error)
[![Total Downloads](https://poser.pugx.org/restyphp/slim-json-handler-error/downloads)](https://packagist.org/packages/restyphp/slim-json-handler-error)
[![composer.lock](https://poser.pugx.org/restyphp/slim-json-handler-error/composerlock)](https://packagist.org/packages/restyphp/slim-json-handler-error)


Redefine el formato de los mensajes de Slim a JSON. Implementa [JSON-API Errors]([JSON-API Errors](http://jsonapi.org/format/#errors)) (v1.0).

Versión estable
---------------

0.4.1

License
-------

The MIT License (MIT). Ver el archivo [LICENSE](LICENSE.md) para más información

Introducción
------------

Slim posee cuantro handlers para manejar distintos tipos de error

* Errores de PHP (PhpError)
* Ruta no encontrada (NotFound)
* Método HTTP incorrecto (NotAllowed)
* Captura de excepciones de usuario (Error)

Cada uno de ellos devuelve el error en el formato que sea solicitado por a cabecera Content-type (hmtl, json, etc). Este middleware reescribe estos handlers para que siempre devuelvan formato JSON.

__Formato de respuesta__

Para unificar el formato de respuesta se siguió el estandar de [JSON-API Error](http://jsonapi.org/format/#errors)

### Ejemplo

```
{
  "errors": [
    {
      "title": "Internal server error",
      "details": "...",
      "code": XXX,
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

Configuración de Slim
---------------------

```php

// Slim
use Slim\App;
use Resty\Slim\BuilderJsonErrorResponses;

$config = [
    // ....
];

// para Desarrollo / QA
$config['settings'] = [
    "displayErrorDetails" => true
];

// para Producción
$config['settings'] = [
    "displayErrorDetails" => false
];

// Redefine - errors
$config['errorHandler'] = BuilderJsonErrorResponses::jsonError();
$config['phpErrorHandler'] = BuilderJsonErrorResponses::jsonPhpError();
$config['notFoundHandler'] = BuilderJsonErrorResponses::jsonNotFound();
$config['notAllowedHandler'] = BuilderJsonErrorResponses::jsonNotAllowed();

$app = new App($config);
// ...
```

Mensajes de error
--------

### Errores de PHP

Clase: `\Resty\Slim\Handler\Error`

```
{
  "errors": [
    {
        "title": "Internal server error",
        "details": "...",
        "code": 0,
        "status": 500,
        "source": {
            "file": "...",
            "line": "..."
        },
        "meta": {
            "trace": [...]
        }
    }
  ]
}
```

### Ruta no encontrada

Clase: `\Resty\Slim\Handler\NotFound`

```
{
  "errors": [
    {
      "title": "Page not found",
      "details": "Request => GET:http://www.dummy.com/dummies",
      "code": 0,
      "status": 404
    }
  ]
}
```

### Método HTTP incorrecto

Clase: `\Resty\Slim\Handler\NotAllowed`

```
{
  "errors": [
    {
      "title": "Method not allowed",
      "details": "Request => POST:http://www.dummy.com. Method not allowed. Must be one of GET",
      "code": 0,
      "status": 405
    }
  ]
}
```

### Captura de excepciones de usuario

Clase: `\Resty\Slim\Handler\Error`

```
{
  "errors": [
    {
        "title": "Internal server error",
        "details": "...",
        "code": 0,
        "status": 500,
        "source": {
            "file": "...",
            "line": "..."
        },
        "meta": {
            "trace": [...]
        }
    }
  ]
}
```

