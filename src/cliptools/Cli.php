<?php
/**
 * Clip
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
 * Clase base para crear scripts para PHP Cli
 *
 * Define metodos abastractos de ayuda, version y validacion para los scripts.
 * Obtiene todos los parametros enviados al script mediante el objeto \cliptools\Opts.
 *
 * @category  Cliptools
 * @package   Cliptools
 * @author    Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright 2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 * @abstract
 */
abstract class Cli
{
    const ERR_NOT_CLI = 'El script solo puede ser utilizado desde linea de comando';
    /**
     * Contiene una instancia de \cliptools\Opts
     * Es estatica asi todas las clases hijas de Clip tienen disponibles los parametros enviados en la linea de comando
     * @var \cliptools\Opts
     */
    protected $opts = null;
    /**
     * Contiene una instancia de \cliptools\Writer
     * @var \cliptools\Writer
     */
    protected $writer = null;
    /**
     * run method
     *
     * @return void
     */
    public function run()
    {
        $this->isCli();
        $this->callHelp();
        $this->callVersion();
        $this->callValidate();
    }
    /**
     * Valida si la clase se esta utilizando por linea de comando. Si no es asi genera una excepcion del tipo RuntimeException
     *
     * @return void
     * @final
     */
    final protected function isCli()
    {
        if (stripos(PHP_SAPI, 'cli') === false) {
            throw new \RuntimeException(static::ERR_NOT_CLI);
        }
    }
    /**
     * Recupera y almacena las opciones en viadas en la linea de comando
     *
     * @param \cliptools\Opts $opts objeto que procesa los parametros enviados por linea de comando
     *
     * @return \cliptools\Cli
     * @final
     */
    final public function opts(\cliptools\Opts $opts)
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
    final public function writer(\cliptools\Writer $writer)
    {
        $this->writer = $writer;
        $this->writer->verbose(in_array('v', $this->opts->short));
        $this->writer->quite(in_array('q', $this->opts->short));
        return $this;
    }
    /**
     * Verifica si debe validar los parametros de entrada
     *
     * @return void
     * @final
     */
    final protected function callValidate()
    {
        $valid = $this->validate($this->opts);
        if ($valid !== true) {
            $this->writer->write("Error:", 'red')
                ->nl()
                ->write(" ".$valid)
                ->nl();
            exit;
        }
    }
    /**
     * Verifica si se invoco a la ayuda, si es asi la imprime en pantalla y para la ejecución del script
     * La ayuda es invocada mendiante los parametros -h o --help
     *
     * @return void
     * @final
     */
    final protected function callHelp()
    {
        if (in_array('h', $this->opts->short) || isset($this->opts->long['help'])) {
            $this->help();
            exit;
        }
    }
    /**
     * Verifica si se invoco a version, si es asi la imprime en pantalla y para la ejecución del script
     * La version es invocada mediante el parametro --version
     *
     * @return void
     * @final
     */
    final protected function callVersion()
    {
        if (isset($this->opts->long['version'])) {
            $this->version();
            exit;
        }
    }
    /**
     * Valida los datos de entrada
     *
     * @param \cliptools\Opts $opts objeto con los parametros de entrada del script
     *
     * @return true|string si no hubo error devuelve true, de lo contrario el mensaje de error
     */
    abstract protected function validate(\cliptools\Opts $opts);
    /**
     * Imprime la ayuda en pantalla
     *
     * @return void
     */
    abstract protected function help();
    /**
     * Imprime la version en pantalla
     *
     * @return void
     */
    abstract protected function version();
}
