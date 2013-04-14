<?php
/**
 * Writer
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
 * Clase para enviar mensajes a la consola
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Writer
{
    /**
     * Array con los distintos colores de fuente
     * @var array
     */
    protected $foregroundColors = array(
        'black' => '0;30',
        'blue' => '0;34',
        'green' => '0;32',
        'cyan' => '0;36',
        'red' => '0;31',
        'purple' => '0;35',
        'brown' => '0;33',
        'yellow' => '1;33',
        'white' => '1;37',
        'darkGray' => '1;30',
        'lightGray' => '0;37',
        'lightPurple' => '1;35',
        'lightRed' => '1;31',
        'lightCyan' => '1;36',
        'lightGreen' => '1;32',
        'lightBlue' => '1;34'
    );
    /**
     * Array con los distintos colores de fondo de fuente
     * @var array
     */
    protected $backgroundColors = array(
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'gray' => '47'
    );
    /**
     * Indica si se esta corriendo en windows o no
     * @var bool
     */
    protected $isWin = false;
    /**
     * Indica si tiene la extension readline habilitada
     * @var bool
     */
    protected $readline = false;
    /**
     * Indica si el modo verbose esta activo
     * @var bools
     */
    protected $v = true;
    /**
     * Indica si el modo quiet esta activo
     * @var bool
     */
    protected $silence = false;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isWin = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN');
        $this->readline = extension_loaded('readline');
    }
    /**
     * Setea el estado de verbose.
     *
     * @param bool $v valor a setear
     *
     * @see self::vwrite
     * @see self::vinc
     * @return void
     */
    public function verbose($v)
    {
        $this->v = $v;
        return $this;
    }
    /**
     * Indica si se deben ocultar todos los mensajes
     *
     * @param bool $silence valor a setear
     *
     * @see self::write
     * @see self::vwrite
     * @see self::inc
     * @see self:vinc
     * @return void
     */
    public function silence($silence)
    {
        $this->silence = $silence;
        return $this;
    }
    /**
     * Escribe un texto en consola
     *
     * @param string|array $sText texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param bool         $force desestima el valor de silence y fuerza la escritura en consola
     *
     * @return void
     */
    public function write($sText='', $force=false)
    {
        if ($this->silence === true && $force === false) {
            return $this;
        }
        if (is_array($sText)) {
            $sText = implode(PHP_EOL, $sText);
        }
        return $this->push($sText);
    }
    /**
     * Escribe un texto en consola si el valor de verbose == false
     *
     * @param string|array $sText texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param bool         $force desestima el valor de silence y fuerza la escritura en consola
     *
     * @return void
     */
    public function vwrite($sText='', $force=false)
    {
        if ($this->v === true) {
            return $this->write($sText, $force);
        }
        return $this;
    }
    /**
     * Escribe un texto en consola
     *
     * @param string|array $sText       texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param string       $sForeground color del texto
     * @param string       $sBackground color de fondo
     * @param string       $force       fuerza imprimir el mensaje
     *
     * @throws \Exception si el color de fondo o de texto no son validos
     * @return void
     */
    public function colorize($sText, $sForeground, $sBackground = null, $force=false)
    {
        if ($this->silence === true && $force === false) {
            return $this;
        }
        $string = '';
        if ($sForeground!== null && !array_key_exists($sForeground, $this->foregroundColors)) {
            throw new \InvalidArgumentException('Invalid color '.$sForeground);
        } elseif ($sForeground !== null) {
            $string = "\033[".$this->foregroundColors[$sForeground]."m";
        }

        if ($sBackground !== null && !array_key_exists($sBackground, $this->backgroundColors)) {
            throw new \InvalidArgumentException('Invalid background color: '.$sBackground);
        } elseif ($sBackground !== null) {
            $string .= "\033[".$this->backgroundColors[$sBackground]."m";
        }
        $string .= $sText."\033[0m";
        return $this->push($string);
    }
    /**
     * Imprime un salto de linea
     *
     * @param int $count cantidad de nuevas lineas a imprimir
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function nl($count=1)
    {
        if ($this->silence === true) {
            return $this;
        }
        for ($i=0; $i<$count; $i++) {
            $this->push(PHP_EOL);
        }
        return $this;
    }
    /**
     * Limpia la consola
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function clear()
    {
        if ($this->isWin) {
            $this->nl(40);
        } else {
            $this->push(chr(27)."[H".chr(27)."[2J");
        }
        return $this;
    }
    /**
     * Manda un mensaje ya formateado a consola
     *
     * @param string $sText mensaje a mostrar
     *
     * @codeCoverageIgnore
     * @return \cliptools\Writer
     */
    protected function push($sText)
    {
        fwrite(STDOUT, $sText);
        return $this;
    }
}
