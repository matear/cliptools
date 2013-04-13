<?php
/**
 * Ejemplo de script usando la clase Opts
 *
 * Para probar el ejemplo invocar al script de la siguiente forma
 * php samples/opts.php -v --param=key --param2 cliptools
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

$opts = new \cliptools\Opts();
$opts->read();

echo "short params: ".PHP_EOL;
echo print_r($opts->short, true);

echo PHP_EOL.PHP_EOL;

echo "long params: ".PHP_EOL;
echo print_r($opts->long, true);

echo PHP_EOL.PHP_EOL;

echo "input params: ".PHP_EOL;
echo print_r($opts->input, true);
