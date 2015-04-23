<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Formatter\DigitsFormatter;
use Thunder\Numbase\Formatter\PermissiveFormatter;
use Thunder\Numbase\Formatter\StrictFormatter;
use Thunder\Numbase\Symbols\Base62Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FormatterTest extends \PHPUnit_Framework_TestCase
    {
    public function testFormatters()
        {
        $symbols = new Base62Symbols();

        $this->assertEquals('12', (new PermissiveFormatter(':'))->format(array(1, 2), $symbols));
        $this->assertEquals('100:200', (new PermissiveFormatter(':'))->format(array(100, 200), $symbols));

        $this->assertEquals('12', (new StrictFormatter())->format(array(1, 2), $symbols));

        $this->assertEquals(array(1, 2), (new DigitsFormatter())->format(array(1, 2), $symbols));
        $this->assertEquals(array(100, 200), (new DigitsFormatter())->format(array(100, 200), $symbols));
        }

    public function testExceptionInvalidSymbolStrictFormatter()
        {
        $formatter = new StrictFormatter();
        $this->setExpectedException('InvalidArgumentException');
        $formatter->format(array(100), new Base62Symbols());
        }
    }
