<?php
/**
 * Notify
 *
 * PHP version 5.3
 *
 * Copyright (c) 2013 mostofreddy <mostofreddy@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category   Progress
 * @package    Cliptools
 * @subpackage Progress
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
namespace cliptools\progress;
/**
 * Clase base para distintas notificaciones como por ejemplo barras de progreso, puntos de progreso, loading, etc.
 *
* @category   Progress
 * @package    Cliptools
 * @subpackage Progress
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
abstract class Progress
{
    protected $bar = '';
    protected $preMsg = '';
    protected $postMsg = '';
    protected $msg = '';
    protected $mensaje = 'processing';

    protected $writer = null;
    protected $total = 0;
    protected $current = 0;
    /**
     * Logica para mostrar el mensaje
     *
     * @return void
     */
    abstract protected function display();
    /**
     * Setea el mensaje que tendra la barra de progreso
     *
     * @param string $msg mensaje de barra de progreso
     *
     * @return \cliptools\Progress
     */
    public function setMessage($msg)
    {
        $this->mensaje = $msg;
        return $this;
    }
    /**
     * Setea la dependencia al objeto writer
     *
     * @param \cliptools\Writer $writer objeto writer
     *
     * @return \cliptools\Progress
     */
    public function setWriter(\cliptools\Writer $writer)
    {
        $this->writer = $writer;
        return $this;
    }
    /**
     * Setaa el total de la barra de progreso
     *
     * @param int $total indica el valor maximo de la barra de progreso
     *
     * @return \cliptools\Progress
     */
    public function setTotal($total)
    {
        $this->total = (int) $total;
        if ($this->total<0) {
            $this->total = 0;
        }
        return $this;
    }
    /**
     * Muestra la barra de progreso en pantalla
     *
     * @param int $inc incremento
     *
     * @return [type] [description]
     */
    public function show($inc=1)
    {
        $this->inc($inc);
        if ($this->isUpdate()) {
            $this->writer->write("\r");
            $this->display();
            return;
        }
        $this->writer->write("\r");
        $this->display();
        return;
    }
    /**
     * Incrementa el valor de current
     *
     * @param integer $inc incremento
     *
     * @return \cliptools\Progress
     */
    protected function inc($inc=1)
    {
        $this->current += (int) $inc;
    }
    /**
     * Indica si se puede actualizar el mensaje o no
     *
     * @return boolean
     */
    protected function isUpdate()
    {
        return ($this->current < $this->total);
    }
    /**
     * [renderMsg description]
     *
     * @param string $msg     msg
     * @param array  $options options
     *
     * @return [type] [description]
     */
    protected function renderMsg($msg, array $options)
    {
        foreach ($options as $k=>$v) {
            $msg = str_replace('{'.$k.'}', $v, $msg);
        }
        return $msg;
    }
    /**
     * Calcula el porcentaje de completado
     *
     * @return real
     */
    public function porc()
    {
        return round(($this->current*100)/$this->total);
    }
}
