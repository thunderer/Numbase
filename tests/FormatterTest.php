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

        $permissive = new PermissiveFormatter($symbols, ':');
        $strict = new StrictFormatter($symbols);
        $digits = new DigitsFormatter();

        $this->assertEquals('12', $permissive->format(array(1, 2), false, $symbols));
        $this->assertEquals('100:200', $permissive->format(array(100, 200), false, $symbols));

        $this->assertEquals('12', $strict->format(array(1, 2), false, $symbols));

        $this->assertEquals(array(1, 2), $digits->format(array(1, 2), false, $symbols));
        $this->assertSame(array(100, 200), $digits->format(array(100, 200), false, $symbols));
        }

    public function testExceptionInvalidSymbolStrictFormatter()
        {
        $formatter = new StrictFormatter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $formatter->format(array(100), false, new Base62Symbols());
        }
    }
