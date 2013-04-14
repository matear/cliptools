<?php
/**
 * WriterTest
 *
 * PHP version 5.3
 *
 * @category   Tests
 * @package    Cliptools
 * @subpackage Tests
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
namespace cliptools\tests\cases;
/**
 * Test unitario para la clase \cliptools\Writer
 *
 * @category   Tests
 * @package    Cliptools
 * @subpackage Tests
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{
    protected static $writer = null;
    /**
     * Testea el constructor
     *
     * @return void
     */
    public function testConstruct()
    {
        static::$writer = new \cliptools\Writer();

        $this->assertAttributeEquals(
            false,
            'isWin',
            static::$writer
        );
        $this->assertAttributeEquals(
            true,
            'readline',
            static::$writer
        );
    }
    /**
     * Testea el metodo verbose
     *
     * @return void
     */
    public function testVerbose()
    {
        static::$writer->verbose(true);
        $this->assertAttributeEquals(
            true,
            'v',
            static::$writer
        );
    }
    /**
     * Testea el metodo silence
     *
     * @return void
     */
    public function testSilence()
    {
        static::$writer->silence(false);
        $this->assertAttributeEquals(
            false,
            'silence',
            static::$writer
        );
    }
    /**
     * Testea el metodo write
     *
     * @return void
     */
    public function testWriteString()
    {
        $stub = $this->getMock('\cliptools\Writer', array('push'));

        $stub->expects($this->any())
            ->method('push')
            ->will($this->returnArgument(0));

        $this->assertEquals('cliptools', $stub->write('cliptools'));
    }
    /**
     * Testea el metodo write
     *
     * @return void
     */
    public function testWriteArray()
    {
        $stub = $this->getMock('\cliptools\Writer', array('push'));

        $stub->expects($this->any())
            ->method('push')
            ->will($this->returnArgument(0));
        $expected = <<<TXT
hola
¿como estas?
TXT;
        $this->assertEquals($expected, $stub->write(array("hola", "¿como estas?")));
    }
    /**
     * Testea el metodo write
     *
     * @return void
     */
    public function testWriteSilence()
    {
        $writer = new \cliptools\Writer();
        $writer->silence(true);
        $this->assertInstanceOf('\cliptools\Writer', $writer->write(array("hola", "¿como estas?")));
    }
    /**
     * Testea el metodo write
     *
     * @return void
     */
    public function testVwriteVerboseTrue()
    {
        $stub = $this->getMock('\cliptools\Writer', array('push'));

        $stub->expects($this->any())
            ->method('push')
            ->will($this->returnArgument(0));
        $stub->verbose(true);
        $this->assertEquals('cliptools', $stub->vwrite('cliptools'));
    }
    /**
     * Testea el metodo write
     *
     * @return void
     */
    public function testVwriteVerbolseFalse()
    {
        $writer = new \cliptools\Writer();
        $writer->verbose(false);
        $this->assertInstanceOf('\cliptools\Writer', $writer->vwrite(array("hola", "¿como estas?")));
    }
    /**
     * Testea el metodo colorize
     *
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testColorizeExceptionForecolor()
    {
        $writer = new \cliptools\Writer();
        $writer->colorize("mensaje", "cliptools");
    }
    /**
     * Testea el metodo colorize
     *
     * @expectedException InvalidArgumentException
     * @return void
     */
    public function testColorizeExceptionBackgroundcolor()
    {
        $writer = new \cliptools\Writer();
        $writer->colorize("mensaje", "yellow", "cliptools");
    }
    /**
     * Testea el metodo colorize
     *
     * @return void
     */
    public function testColorizeSilence()
    {
        $writer = new \cliptools\Writer();
        $writer->silence(true);
        $this->assertInstanceOf('\cliptools\Writer', $writer->colorize("colorize", "blue"));
    }
    /**
     * Testea el metodo colorize
     *
     * @return void
     */
    public function testColorize()
    {
        $stub = $this->getMock('\cliptools\Writer', array('push'));

        $stub->expects($this->any())
            ->method('push')
            ->will($this->returnValue("colorize"));
        $stub->verbose(true);
        $this->assertEquals(
            "colorize",
            $stub->colorize('mensaje', "yellow", "blue")
        );
    }
}
