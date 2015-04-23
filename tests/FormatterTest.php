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

        $permissive = new PermissiveFormatter(':');
        $strict = new StrictFormatter();
        $digits = new DigitsFormatter();

        $this->assertEquals('12', $permissive->format(array(1, 2), $symbols));
        $this->assertEquals('100:200', $permissive->format(array(100, 200), $symbols));

        $this->assertEquals('12', $strict->format(array(1, 2), $symbols));

        $this->assertEquals(array(1, 2), $digits->format(array(1, 2), $symbols));
        $this->assertEquals(array(100, 200), $digits->format(array(100, 200), $symbols));
        }

    public function testExceptionInvalidSymbolStrictFormatter()
        {
        $formatter = new StrictFormatter();
        $this->setExpectedException('InvalidArgumentException');
        $formatter->format(array(100), new Base62Symbols());
        }
    }
