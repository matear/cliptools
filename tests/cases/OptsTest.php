<?php
/**
 * OptsTest
 *
 * PHP version 5.3
 *
 * @category   Tests
 * @package    Clip
 * @subpackage Tests
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
namespace cliptools\tests\cases;
/**
 * Test unitario para la clase \clip\Opts
 *
 * @category   Tests
 * @package    Clip
 * @subpackage Tests
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
class OptsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testea el metodo read
     *
     * @return void
     */
    public function testRead()
    {
        $expected = array(
            "-vgt", "--name=clip", "--read" , "--write=false", "/var/www"
        );
        $_SERVER['argv'] = $expected;
        $obj = new \cliptools\Opts();
        $obj->read();

        $expected = array(
            "name" => "clip",
            'read' => true,
            'write' => false
        );
        $this->assertEquals($expected, $obj->long);
        $expected = array("v", "g", "t");
        $this->assertEquals($expected, $obj->short);
        $expected = array("/var/www");
        $this->assertEquals($expected, $obj->input);
    }
    /**
     * Testea el metodo readArgs cuando existe $_SERVER['argv']
     *
     * @return void
     */
    public function testReadArgsForArgv()
    {
        $method = new \ReflectionMethod(
            '\cliptools\Opts', '_readArgs'
        );
        $method->setAccessible(true);

        $expected = array(
            "-vgt", "--name=cliptools", "/var/www"
        );
        $_SERVER['argv'] = $expected;

        $this->assertEquals(
            $expected,
            $method->invoke(new \cliptools\Opts())
        );
    }
    /**
     * Testea el metodo readArgs cuando existe $_GLOBAL['argv']
     *
     * @return void
     */
    public function testReadArgsForGlobal()
    {
        $_SERVER['argv'] = null;

        if (!is_array($GLOBALS['argv'])) {
            $GLOBALS['argv'] = array("--a");
        }

        $method = new \ReflectionMethod(
            '\cliptools\Opts', '_readArgs'
        );
        $method->setAccessible(true);

        $expected = array(
            "/usr/bin/phpunit", "--configuration", "tests/phpunit.xml"
        );
        $GLOBALS['argv'] = $expected;

        $this->assertEquals(
            $expected,
            $method->invoke(new \cliptools\Opts())
        );
    }
    /**
     * Testea el metodo readArgs lance una excepcion
     *
     * @expectedException \RuntimeException
     *
     * @return void
     */
    public function testReadArgsForException()
    {
        $_SERVER['argv'] = null;
        $GLOBALS['argv'] = null;

        $method = new \ReflectionMethod(
            '\cliptools\Opts', '_readArgs'
        );
        $method->setAccessible(true);

        $expected = array(
            "/usr/bin/phpunit", "--configuration", "tests/phpunit.xml"
        );

        $this->assertEquals(
            $expected,
            $method->invoke(new \cliptools\Opts())
        );
    }
}
