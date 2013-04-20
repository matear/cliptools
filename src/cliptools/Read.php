<?php
/**
 * Read
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
 * Clase para recuperar info desde la consola
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Read
{
    protected $writer = null;
    /**
     * Setea el objeto writer
     *
     * @param \cliptools\Writer $writer objeto writer
     *
     * @return \cliptools\Read
     */
    public function setWriter(\cliptools\Writer $writer)
    {
        $this->writer = $writer;
        return $this;
    }
    /**
     * Lee un dato desde la consola
     *
     * @return string
     */
    public function get()
    {
        return trim(fgets(STDIN));
    }
    /**
     * Prompt en consola
     *
     * @param string $label etiqueta
     *
     * @return string
     */
    public function prompt($label)
    {
        $this->writer->write($label);
        return $this->get();
    }
    /**
     * Recupera info de una pregunta YES/NO
     *
     * @param [type] $label         [description]
     * @param string $defaultOption [description]
     * @param string $error         [description]
     *
     * @return bool
     */
    public function yesno($label, $defaultOption="Y", $error = "Invalid option")
    {
        $options = (strtoupper($defaultOption) === 'Y')?'[Y/n]':'[y/N]';
        $this->writer->write($label." ".$options." ");
        $data = strtoupper($this->get());
        if ($data == '') {
            $data = strtoupper($defaultOption);
        }
        if ($data != "Y" && $data != "N") {
            $this->writer->colorize($error, "red")->nl();
            $this->yesno($label, $defaultOption, $error);
        }
        return ($data == "Y");
    }
    /**
     * Realiza una pregunta y devuelve el indice de la opcion seleccionada.
     * Si no se selecciona una opción valida se muesta mensaje de error y se vuelve a realizar la repregunta
     *
     * @param string $label   etiqueta de la pregunta
     * @param array  $options opciones a seleccionar
     * @param string $error   mensaje de error al no seleccionar una opcion correcta
     *
     * @return int
     */
    public function options($label, $options=array(), $error = "Invalid option")
    {
        $this->writer->write($label)->nl();
        $count = count($options);
        if ($count === 0) {
            throw new \InvalidArgumentException("Invalid param 'options', the parameter can not be empty");
        }
        for ($i = 0; $i < $count; $i++) {
            $this->writer->write(($i + 1)." - ".$options[$i])
                ->nl();
        }
        $data = (int) $this->get();
        if ($data > 0 && $data <= $count) {
            return ($data-1);
        } else {
            $this->writer->colorize($error, "red")->nl();
            $this->option($label, $options, $error);
        }
    }
}
