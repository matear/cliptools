<?php
/**
 * Ejemplo de script usando la clase Arguments
 *
 * Para probar el ejemplo invocar al script de la siguiente forma
 * php samples/arguments.php -v --param=key --param2 cliptools
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
$opts = new \cliptools\Arguments();

$opts->addFlag(
    array('h', 'help'),
    array(
        'description' => 'Imprime la ayuda y sale'
    )
);
$opts->addFlag(
    array('v'),
    array(
        'description' => 'Verbose'
    )
);
$opts->addFlag(
    array('title'),
    array(
        'default' => "cliptools",
        'description' => 'Titulo'
    )
);
$opts->proccess();

class App extends \cliptools\Cli
{
    /**
     * Devuelve el texto de ayuda
     *
     * @return string
     */
    protected function help()
    {
        $txt = <<<TXT
Usage:
 php cli.php [opts] --title="titulo"


TXT;
        $txt .= $this->opts->usage();
        return $txt;
    }
    /**
     * Devuelve el texto de version
     *
     * @return string
     */
    protected function version()
    {
        $txt = <<<TXT
Version: x.y.z

TXT;
        return $txt;
    }
}
$cli = new App();
$cli->setWriter($writer)
    ->setOpts($opts)
    ->run();
