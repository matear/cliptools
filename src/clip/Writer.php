<?php
/**
 * Writer
 *
 * PHP version 5.3
 *
 * Copyright (c) 2013 mostofreddy <mostofreddy@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Clip
 * @package   Clip
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace clip;
/**
 * Clase que permite escribir e interacturar con la consola.
 *
 * @category  Clip
 * @package   Clip
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
    protected $q = false;
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
     * Setea el estado de quite
     *
     * @param bool $q valor a setear
     *
     * @see self::write
     * @see self::vwrite
     * @see self::inc
     * @see self:vinc
     * @return void
     */
    public function quite($q)
    {
        $this->q = $q;
        return $this;
    }
    /**
     * Escribe un texto en consola
     *
     * @param string|array $sText       texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param string       $sForeground color del texto
     * @param string       $sBackground color de fondo
     * @param bool         $force       desestima el valor de quirte y fuerza la escritura en consola
     *
     * @return void
     */
    public function write($sText='', $sForeground=null, $sBackground=null, $force=false)
    {
        if ($this->q === true && $force === false) {
            return $this;
        }

        if (is_array($sText)) {
            $sText = implode(PHP_EOL, $sText);
        }

        if ($sForeground || $sBackground) {
            $this->colorize($sText, $sForeground, $sBackground);
            return $this;
        }
        fwrite(STDOUT, $sText);
        return $this;
    }
    /**
     * Escribe un texto en consola si el valor de verbose == false
     *
     * @param string|array $sText       texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param string       $sForeground color del texto
     * @param string       $sBackground color de fondo
     *
     * @return void
     */
    public function vwrite($sText='', $sForeground=null, $sBackground=null)
    {
        if ($this->v === true && $this->q === false) {
            $this->write($sText, $sForeground, $sBackground);
        }
        return $this;
    }
    /**
     * Imprime un incremento en formato punto (.)
     *
     * @return void
     */
    public function inc()
    {
        $this->write('.');
        return $this;
    }
    /**
     * Imprime un incremento en formato punto (.) si verbose == true
     *
     * @return void
     */
    public function vinc()
    {
        $this->vwrite('.');
        return $this;
    }
    /**
     * Escribe un texto en consola
     *
     * @param string|array $sText       texto a escribir, si es un array escribe una linea por cada posicion del array
     * @param string       $sForeground color del texto
     * @param string       $sBackground color de fondo
     *
     * @throws \Exception si el color de fondo o de texto no son validos
     * @return void
     */
    protected function colorize($sText, $sForeground, $sBackground = null)
    {
        $string = '';
        if ($sForeground!== null && !array_key_exists($sForeground, $this->foregroundColors)) {
            throw new \Exception('CLI - color inválido: '.$sForeground);
        } elseif ($sForeground !== null) {
            $string = "\033[".$this->foregroundColors[$sForeground]."m";
        }

        if ($sBackground !== null && !array_key_exists($sBackground, $this->backgroundColors)) {
            throw new \Exception('CLI - color de fondo inválido: '.$sBackground);
        } elseif ($sBackground !== null) {
            $string .= "\033[".$this->backgroundColors[$sBackground]."m";
        }
        $string .= $sText."\033[0m";
        fwrite(STDOUT, $string);
        return $this;
    }
    /**
     * Imprime un salto de linea
     *
     * @param int $count cantidad de nuevas lineas a imprimir
     *
     * @return void
     */
    public function nl($count=1)
    {
        if ($this->q === true) {
            return $this;
        }
        for ($i=0; $i<$count; $i++) {
            fwrite(STDOUT, PHP_EOL);
        }
        return $this;
    }
    /**
     * Limpia la consola
     *
     * @return void
     */
    public function clear()
    {
        if ($this->isWin) {
            $this->newLine(40);
        } else {
            fwrite(STDOUT, chr(27)."[H".chr(27)."[2J");
        }
        return $this;
    }
    /**
     * Imprime un beep
     *
     * @param int $iCant cantidad de beeps
     *
     * @return void
     */
    public function beep($iCant = 1)
    {
        fwrite(STDOUT, str_repeat("\x07", $iCant));
        return $this;
    }
    /**
     * Lee un dato desde la consola
     *
     * @param string $label etiqueta a imprimir antes de leer un dato
     *
     * @return string
     */
    public function read($label = '')
    {
        if ($this->readline) {
            return readline($label);
        }
        echo $label;
        return fgets(STDIN);
    }
    /**
     * Prompt en consola
     *
     * @param string       $sText          texto a imprimir
     * @param string|array $options        opciones validas
     * @param string       $default        valor por default a devolver
     * @param bool         $bRequired      indica si es requerido que se inserte un dato
     * @param bool         $bCaseSensitive indica si los datos son casesensitive
     *
     * @return string
     */
    public function prompt($sText, $options=null, $default=null, $bRequired=false, $bCaseSensitive=false)
    {
        if (is_array($options)) {
            $sText .= ' ['.implode(', ', $options).']: ';
        } elseif (is_string($options) && $options !== '') {
            $sText .= ' ['.$options.']: ';
        }
        $this->write($sText);

        $sInput = null;

        $options = $this->_optionsNormalizeCaseSenstive($options, $bCaseSensitive);
        while (true) {
            $sInput = trim($this->read()) ?: $default;
            if (empty($sInput) && $bRequired === true) {
                $this->write('El valor es requerido.');
                continue;
            }
            if ($bCaseSensitive) {
                if (is_array($options) && !in_array($sInput, $options)) {
                    $this->write('Valor inválido. Pruebe nuevamente: ');
                    continue;
                }
            } else {
                if (is_array($options) && !in_array(strtolower($sInput), $options)) {
                    $this->write('Valor inválido. Pruebe nuevamente: ');
                    continue;
                }
            }
            break;
        }
        return $sInput;
    }
    /**
     * Transforma a minuscula los datos ingresados por consola si casesensitive es false
     *
     * @param string $aOptions       texto ingresado
     * @param bool   $bCaseSensitive indica si es casesensitive
     *
     * @return array
     */
    private function _optionsNormalizeCaseSenstive($aOptions, $bCaseSensitive)
    {
        if (!$bCaseSensitive && is_array($aOptions)) {
            return array_map('strtolower', $aOptions);
        }
        return $aOptions;
    }
}
