<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Formatter\ArrayFormatter;
use Thunder\Numbase\Formatter\FallbackFormatter;
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

        $permissive = new FallbackFormatter($symbols, ':');
        $strict = new StrictFormatter($symbols);
        $digits = new ArrayFormatter();

        $this->assertEquals('12', $permissive->format(array(1, 2), false));
        $this->assertEquals('100:200', $permissive->format(array(100, 200), false));

        $this->assertEquals('12', $strict->format(array(1, 2), false));

        $this->assertEquals(array(1, 2), $digits->format(array(1, 2), false));
        $this->assertSame(array(100, 200), $digits->format(array(100, 200), false));
    }

    public function testExceptionInvalidSymbolStrictFormatter()
    {
        $formatter = new StrictFormatter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $formatter->format(array(100), false);
    }
}
