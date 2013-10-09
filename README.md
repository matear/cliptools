Cliptools
=========

[![Build Status](https://travis-ci.org/mostofreddy/cliptools.png?branch=master)](https://travis-ci.org/mostofreddy/cliptools)
[![Coverage Status](https://coveralls.io/repos/mostofreddy/cliptools/badge.png)](https://coveralls.io/r/mostofreddy/cliptools)
[![Latest Stable Version](https://poser.pugx.org/mostofreddy/cliptools/v/stable.png)](https://packagist.org/packages/mostofreddy/cliptools)
[![Dependency Status](https://www.versioneye.com/user/projects/5254ceaf632bac47e70002de/badge.png)](https://www.versioneye.com/user/projects/5254ceaf632bac47e70002de)

Conjunto de herramientas para facilitar la creacion de aplicaciones PHP para correr por consola

Versión
-------

__v0.5.3__ stable

Features
--------

* Recuperar los valores de entrada de un script por consola (script.php -v --key=value)
* Escribir mensajes por consola
* Verbose enabled/disabled para controlar la salida de mensajes
* Silence para no imprimir ningún mensaje
* Realizar preguntas, preguntas yes/no y menu de opciones
* Crear barras de progreso al estilo proccess [======>    ] 50%
* Clase base para crear aplicaciones que corran por shell o cron

Licencia
-------
Software bajo licencia [MIT](http://opensource.org/licenses/mit-license.php)

Instalación
-----------

### Requerimientos

- PHP >= 5.3.0

### github

    cd /var/www
    git clone git@github.com:matear/clip.git

### composer

    "require": {
        "php": ">=5.3.0",
        "matear/cliptools": "0.*",
    }

Ejemplos / Demos
----------------

Visite la carpeta de [samples](https://github.com/mostofreddy/cliptools/tree/master/samples)

Tests
-----

    phpunit --configuration tests/phpunit.xml
