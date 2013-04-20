<?php
/**
 * Bar
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
 * Crea una barra de progreso al estilo
 * processing ..............               . 100%
 *
 * @category   Progress
 * @package    Cliptools
 * @subpackage Progress
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
class Dot extends \cliptools\progress\Progress
{
    protected $bar = '.';
    protected $preMsg = ' {msg} ';
    protected $postMsg = ' {porc}% ';
    protected $msg = '{pre}{bar}{post}';
    /**
     * [display description]
     *
     * @return [type] [description]
     */
    protected function display()
    {
        $porc = $this->porc();
        $pre = $this->renderMsg($this->preMsg, array('msg' => $this->mensaje));
        $post = $this->renderMsg($this->postMsg, array('porc' => $porc));

        $totalColsShell = \cliptools\Shell::columns();
        $dispColsShell = $totalColsShell - strlen($pre.$post);
        $totalCharBar = round(($porc * $dispColsShell)/100);
        $bar = str_pad($this->bar, $totalCharBar, $this->bar);
        $bar = str_pad($bar, $dispColsShell);
        $this->writer->write($this->renderMsg($this->msg, compact("post", "pre", "bar")));
    }
}
