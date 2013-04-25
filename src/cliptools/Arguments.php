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
 * Uso:
 * php script.php -vxf --title="Cliptools lib" otherOrguments1 otherOrguments2
 *
 * $o = new Arguments();
 * $o->proccess();
 * $o->get("v");         // return: true
 * $o->get("z");         // return: false
 * $o->get("title");     // return: Cliptools lib
 * $o->get("others");    // return: array("otherOrguments1", "otherOrguments2")
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Arguments
{
    protected $input = array();
    protected $flags = array();
    protected $alias = array('others' => array());
    /**
     * Agrega una opcion
     *
     * @param string $alias   codename
     * @param array  $options opciones
     *
     * @return \cliptools\Arguments
     */
    public function addFlag($alias, $options=array())
    {
        $options += array(
            'alias' => $alias,
            'description' => '',
            'default' => null,
            'required' => false
        );
        $this->flags[]  = $options;
        $flags = array_combine($alias, array_fill(0, count($alias), $options['default']));
        $this->alias = array_merge($this->alias, $flags);
        return $this;
    }
    /**
     * Devuelve un string formateado con la descripcion de los flags
     *
     * @return string
     */
    public function usage()
    {
        $usage = "Params:".PHP_EOL;
        foreach ($this->flags as $flag) {
            $usage .= " ".str_pad(implode(", ", $flag['alias']), 20);
            $usage .= $flag['description'];
            if ($flag['default'] != null) {
                $usage .= " [default: ".$flag["default"]."]";
            }
            if ($flag['required'] == true) {
                $usage .= " [required]";
            }
            $usage .= PHP_EOL;
        }
        return $usage;
    }
    /**
     * Procesa
     *
     * @return void
     */
    public function proccess()
    {
        $this->input = $this->_readArgs();
        $this->parse();
    }
    /**
     * Busca y devuelve un valor. Si no es encontrado devuelve null
     *
     * @param string $key clave pasada x consola
     *
     * @return mixed
     */
    public function get($key=null)
    {
        if ($key === null) {
            return $this->alias;
        }
        return array_key_exists($key, $this->alias)?$this->alias[$key]:null;
    }
    /**
     * Parsea los datos
     *
     * @return void
     */
    protected function parse()
    {
        foreach ($this->input as $opt) {
            $matches = array();
            //obtiene todos los parametros
            if (preg_match('/^-{1,2}([a-zA-Z0-9]*)=?(.*)$/', $opt, $matches)) {
                $match = array();
                //verifica si es un parametro short
                if (preg_match("/^-([a-zA-Z0-9]+)/", $matches[0], $match)) {
                    $flags = str_split($match[1]);
                    $flags = array_combine($flags, array_fill(0, count($flags), true));
                    $this->alias = $flags + $this->alias;
                } else {
                    //es un paremtro long
                    switch ($matches[2]) {
                    case '':
                    case 'true':
                        $this->alias[$matches[1]] = true;
                        break;
                    case 'false':
                        $this->alias[$matches[1]] = false;
                        break;
                    default:
                        $this->alias[$matches[1]] = $matches[2];
                    }
                }
            } else {
                $this->alias['others'][] = $opt;
            }
        }
    }
    /**
     * Recupera los parametros provenientes de la linea de comando
     *
     * @throws \Exception si no los puede recuperar
     * @return array
     */
    private function _readArgs()
    {
        if (is_array($_SERVER['argv'])) {
            return array_slice($_SERVER['argv'], 1);
        }
        return array();
    }
}
