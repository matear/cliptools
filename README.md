Cliptools
=========

Cliptools es un mini framework que contiene herramientas para facilitar la creacion de aplicaciones PHP para correr por consola

Versión
-------
v0.5.0

Build Status
------------

[![Build Status](https://travis-ci.org/matear/cliptools.png?branch=master)](https://travis-ci.org/matear/cliptools)(https://travis-ci.org/mostofreddy/cliptools)

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
En la carpeta [samples](https://github.com/matear/cliptools/tree/master/samples) se pueden encontrar ejemplos de uso

Tests
-----

    phpunit --configuration tests/phpunit.xml
