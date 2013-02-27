<?php
/**
 * Opts
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
namespace cliptools;
/**
 * Clase que recupera los parametros enviados por consola al script.
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
final class Opts
{
    const ERR_READ_ARGS = 'No se pueden leear los parametros de entrada (register_argc_argv=Off?)';
    /**
     * Array asociativo donde la clave corresponde al nombre de la variable que se envia
     * Por ejemplo ./miScript --saludo=hola => donde saludo es la clave del array y hola es su valor
     *
     * @var array
     */
    public $long = array();
    /**
     * Array donde se cuentran todos los parametros cortos.
     * Por ejemplo ./miScript -vft
     *
     * @var array
     */
    public $short = array();
    /**
     * Array con todos los demas parametros que se envien al script
     *
     * @var array
     */
    public $input = array();
    /**
     * Procesa los parametros enviados en la linea de comando
     * Los parametros con formato --variable=valor son almacenados en $long
     * Los parametros con formato --variable son almacenados en $short
     * Los demas parametros son almacenados en $input
     *
     * @return void
     */
    public function read()
    {
        $opts = $this->_readArgs();
        $self = $this;

        $callBack = function ($opt) use ($self) {
            $matches = array();
            //obtiene todos los parametros
            if (preg_match('/^-{1,2}([a-zA-Z0-9]*)=?(.*)$/', $opt, $matches)) {
                $match = array();
                //verifica si es un parametro short
                if (preg_match("/^-([a-zA-Z0-9]+)/", $matches[0], $match)) {
                    $self->short = array_merge($self->short, str_split($match[1]));
                } else {
                    //es un paremtro long
                    switch ($matches[2]) {
                    case '':
                    case 'true':
                        $self->long[$matches[1]] = true;
                        break;
                    case 'false':
                        $self->long[$matches[1]] = false;
                        break;
                    default:
                        $self->long[$matches[1]] = $matches[2];
                    }
                }
            } else {
                $self->input[] = $opt;
            }
        };
        array_walk($opts, $callBack);
    }
    /**
     * Recupera los parametros de la linea de comando
     *
     * @throws \Exception si no los puede recuperar
     * @return array
     */
    private function _readArgs()
    {
        if (is_array($_SERVER['argv'])) {
            return $_SERVER['argv'];
        }
        if (is_array($GLOBALS['argv'])) {
            return $GLOBALS['argv'];
        }
        throw new \RuntimeException(static::ERR_READ_ARGS);
    }
}
