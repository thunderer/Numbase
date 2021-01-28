<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Formatter\ArrayFormatter;
use Thunder\Numbase\Formatter\FallbackFormatter;
use Thunder\Numbase\Formatter\StrictFormatter;
use Thunder\Numbase\Symbols\Base62Symbols;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FormatterTest extends TestCase
{
    public function testFormatters(): void
    {
        $symbols = new Base62Symbols();

        $permissive = new FallbackFormatter($symbols, ':');
        $strict = new StrictFormatter($symbols);
        $digits = new ArrayFormatter();

        self::assertEquals('12', $permissive->format(array(1, 2), false));
        self::assertEquals('100:200', $permissive->format(array(100, 200), false));

        self::assertEquals('12', $strict->format(array(1, 2), false));

        self::assertEquals(array(1, 2), $digits->format(array(1, 2), false));
        self::assertSame(array(100, 200), $digits->format(array(100, 200), false));
    }

    public function testExceptionInvalidSymbolStrictFormatter(): void
    {
        $formatter = new StrictFormatter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $formatter->format(array(100), false);
    }
}
