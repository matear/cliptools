<?php
/**
 * Ejemplo progressBar
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

$bar = new \cliptools\progress\Bar();
$bar->setTotal(15);
$bar->setWriter($writer);

for ($i=0; $i<15; $i++) {
    $bar->show();
    sleep(1);
}
$writer->nl()->nl();

$bar = new \cliptools\progress\Dot();
$bar->setTotal(15);
$bar->setMessage("Procesando:");
$bar->setWriter($writer);

for ($i=0; $i<15; $i++) {
    $bar->show();
    sleep(1);
}
