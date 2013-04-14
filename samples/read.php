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

$writer = new \cliptools\Writer();
$read = new \cliptools\Read();
$read->setWriter($writer);

$data = $read->prompt("¿Cuanto es 3 * 5? ");

$writer->write("La data recuperada fue: ".$data)
    ->nl()
    ->nl();

$data = $read->yesno("¿3 * 5 es igual a 15?", "n");
var_dump($data);
$writer->nl();

$data = $read->option("Elije tu propia aventura", array('Accion', 'Terror'));
