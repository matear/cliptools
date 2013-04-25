<?php
/**
 * OptsTest
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
 * Test unitario para la clase \cliptools\Opts
 *
 * @category   Tests
 * @package    Cliptools
 * @subpackage Tests
 * @author     Federico Lozada Mosto <mostofreddy@gmail.com>
 * @copyright  2013 Federico Lozada Mosto <mostofreddy@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link       http://www.mostofreddy.com.ar
 */
class ArgumentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testea el metodo get
     *
     * @return void
     */
    public function testShortArguments()
    {
        $expected = array(
            "php script.php", "-vgt", "--name=clip", "--read" , "--write=false", "/var/www"
        );
        $_SERVER['argv'] = $expected;
        $obj = new \cliptools\Arguments();
        $obj->addFlag(array("v"));
        $obj->addFlag(array("g"));
        $obj->addFlag(array("z"));
        $obj->proccess();

        $this->assertTrue($obj->get("v"));
        $this->assertTrue($obj->get("g"));
        $this->assertTrue($obj->get("t"));
        $this->assertNull($obj->get("z"));
    }
    /**
     * Testea el metodo get
     *
     * @return void
     */
    public function testLongArguments()
    {
        $expected = array(
            "php script.php", "-vgt", "--name=clip", "--read" , "--write=false", "/var/www"
        );
        $_SERVER['argv'] = $expected;
        $obj = new \cliptools\Arguments();
        $obj->addFlag(array("name"), array('default'=>'xx'));
        $obj->addFlag(array("title"), array('default'=>'yy'));
        $obj->proccess();

        $this->assertEquals("clip", $obj->get("name"));
        $this->assertEquals("yy", $obj->get("title"));
    }
    /**
     * Testea el metodo get
     *
     * @return void
     */
    public function testOtherArguments()
    {
        $expected = array(
            "php script.php", "-vgt", "--name=clip", "--read" , "--write=false", "/var/www"
        );
        $_SERVER['argv'] = $expected;
        $obj = new \cliptools\Arguments();
        $obj->proccess();

        $this->assertEquals(array("/var/www"), $obj->get("others"));
    }
    /**
     * Testea el metodo get
     *
     * @return void
     */
    public function testGetAll()
    {
        $expected = array(
            "php script.php", "-v", "--name=clip"
        );
        $_SERVER['argv'] = $expected;
        $obj = new \cliptools\Arguments();
        $obj->proccess();

        $this->assertEquals(array("v" => true, "name" => "clip", 'others' => array()), $obj->get());
    }
    /**
     * Testea el metodo usage
     *
     * @return void
     */
    public function testUsage()
    {
        $expected = "Params:".PHP_EOL;
        $expected .= " ".str_pad("v", 20)."verbose".PHP_EOL;
        $expected .= " ".str_pad("title", 20)."title [required]".PHP_EOL;
        $expected .= " ".str_pad("z", 20)." [default: z value]".PHP_EOL;
        $obj = new \cliptools\Arguments();

        $obj->addFlag(array("v"), array("description" => "verbose"));
        $obj->addFlag(array("title"), array("description" => "title", "required" =>true));
        $obj->addFlag(array("z"), array("default" => "z value"));
        $obj->proccess();
        $data = $obj->usage();

        $this->assertEquals($expected, $data);
    }
    // /**
    //  * Testea el metodo readArgs cuando existe $_SERVER['argv']
    //  *
    //  * @return void
    //  */
    // public function testReadArgsForArgv()
    // {
    //     $method = new \ReflectionMethod(
    //         '\cliptools\Opts', '_readArgs'
    //     );
    //     $method->setAccessible(true);

    //     $expected = array(
    //         "-vgt", "--name=cliptools", "/var/www"
    //     );
    //     $_SERVER['argv'] = $expected;

    //     $this->assertEquals(
    //         $expected,
    //         $method->invoke(new \cliptools\Opts())
    //     );
    // }
    // /**
    //  * Testea el metodo readArgs cuando existe $_GLOBAL['argv']
    //  *
    //  * @return void
    //  */
    // public function testReadArgsForGlobal()
    // {
    //     $_SERVER['argv'] = null;

    //     if (!is_array($GLOBALS['argv'])) {
    //         $GLOBALS['argv'] = array("--a");
    //     }

    //     $method = new \ReflectionMethod(
    //         '\cliptools\Opts', '_readArgs'
    //     );
    //     $method->setAccessible(true);

    //     $expected = array(
    //         "/usr/bin/phpunit", "--configuration", "tests/phpunit.xml"
    //     );
    //     $GLOBALS['argv'] = $expected;

    //     $this->assertEquals(
    //         $expected,
    //         $method->invoke(new \cliptools\Opts())
    //     );
    // }
    /**
     * Testea el metodo readArgs lance una excepcion
     *
     * @return void
     */
    public function testReadArgsEmpty()
    {
        $_SERVER['argv'] = null;

        $method = new \ReflectionMethod(
            '\cliptools\Arguments', '_readArgs'
        );
        $method->setAccessible(true);

        $expected = array();

        $this->assertEquals(
            $expected,
            $method->invoke(new \cliptools\Arguments())
        );
    }
}
