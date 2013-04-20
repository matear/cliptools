<?php
/**
 * Ejemplo de script usando la clase Writer
 *
 * Para probar el ejemplo invocar al script de la siguiente forma
 * php samples/writer.php
 *
 * PHP version 5.3
 *
 * Copyright (c) 2013 mostofreddy <mostofreddy@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */

require_once "vendor/autoload.php";


//cantidad de columnas del shell
echo "la cantidad de columnas es: ".\cliptools\Shell::columns();
echo PHP_EOL;
