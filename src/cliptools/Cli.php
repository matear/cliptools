<?php
/**
 * Cli
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
 * Clase base para crear aplicaciones que funcionen por consola
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
abstract class Cli
{
    /**
     * Contiene una instancia de \cliptools\Writer
     * @var \cliptools\Writer
     */
    protected $writer = null;
    /**
     * Contiene una instancia de \cliptools\Arguments
     * @var \cliptools\Arguments
     */
    protected $opts = null;
    /**
     * Recupera y almacena las opciones en viadas en la linea de comando
     *
     * @param \cliptools\Opts $opts objeto que procesa los parametros enviados por linea de comando
     *
     * @return \cliptools\Cli
     * @final
     */
    final public function setOpts(\cliptools\Arguments $opts)
    {
        $this->opts = $opts;
        return $this;
    }
    /**
     * Devuelve un objeto writer
     *
     * @param \cliptools\Writer $writer objeto para escribir en consola
     *
     * @return \cliptools\Cli
     * @final
     */
    final public function setWriter(\cliptools\Writer $writer)
    {
        $this->writer = $writer;
        return $this;
    }
    /**
     * Valida si la clase se esta utilizando por linea de comando.
     * Si no es asi genera una excepcion del tipo RuntimeException
     *
     * @throws \RuntimeException cuando la clase no es usada por shell
     * @return void
     * @final
     */
    final protected function isCli()
    {
        if (stripos(PHP_SAPI, 'cli') === false) {
            throw new \RuntimeException("aa");
        }
        return true;
    }
    /**
     * Verifica si se invoco a la ayuda, si es asi llama a la funcion help e imprime el resultado en pantalla
     * La ayuda es invocada mendiante los parametros -h o --help
     *
     * @return \cliptools\Cli
     * @final
     */
    final protected function callHelp()
    {
        if ($this->opts->get('h') || $this->opts->get("help")) {
            $this->writer->write($this->help());
            exit;
        }
        return $this;
    }
    /**
     * Verifica si se invoco a version, si es asi la imprime en pantalla y para la ejecución del script
     * La version es invocada mediante el parametro --version
     *
     * @return \cliptools\Cli
     * @final
     */
    final protected function callVersion()
    {
        if ($this->opts->get('version')) {
            $this->writer->write($this->version());
            exit;
        }
        return $this;
    }
    /**
     * Devuelve el texto de ayuda. Por defecto utiliza el obejeto Arguments para recuperar los posibles parametros
     * q se pueden agregar al script
     *
     * @return string
     */
    public function help()
    {
        return $this->opts->usage();
    }
    /**
     * Devuelve el texto de version
     *
     * @return string
     */
    abstract function version();
    /**
     * run method
     *
     * @return void
     */
    public function run ()
    {
        $this->isCli();
        $this->callHelp();
        $this->callVersion();
    }
}
