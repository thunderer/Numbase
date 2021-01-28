<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Symbols\ArraySymbols;
use Thunder\Numbase\Symbols\Base10Symbols;
use Thunder\Numbase\Symbols\Base62Symbols;
use Thunder\Numbase\Symbols\StringSymbols;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class SymbolsTest extends TestCase
{
    public function testBase62Symbols(): void
    {
        $symbols = new Base62Symbols();

        self::assertSame(0, $symbols->getValue('0'));
        self::assertSame('0', $symbols->getSymbol(0));
        self::assertTrue($symbols->hasSymbol('z'));
        self::assertFalse($symbols->hasSymbol('#'));
        self::assertTrue($symbols->hasValue(10));
        self::assertFalse($symbols->hasValue(100));
    }

    public function testBase10Symbols(): void
    {
        $symbols = new Base10Symbols();

        self::assertSame(0, $symbols->getValue('0'));
        self::assertSame('0', $symbols->getSymbol(0));
        self::assertTrue($symbols->hasSymbol('7'));
        self::assertFalse($symbols->hasSymbol('C'));
        self::assertTrue($symbols->hasValue(9));
        self::assertFalse($symbols->hasValue(100));
    }

    public function testArraySymbols(): void
    {
        $symbols = new ArraySymbols(array(2 => '!', 4 => '@', 6 => '#'));

        self::assertSame(2, $symbols->getValue('!'));
        self::assertSame('@', $symbols->getSymbol(4));
        self::assertTrue($symbols->hasSymbol('#'));
        self::assertFalse($symbols->hasSymbol('V'));
        self::assertTrue($symbols->hasValue(4));
        self::assertFalse($symbols->hasValue(5));
    }

    public function testStringSymbols(): void
    {
        $symbols = new StringSymbols('!@#$%^&*()');

        self::assertSame(2, $symbols->getValue('#'));
        self::assertSame('(', $symbols->getSymbol(8));
        self::assertTrue($symbols->hasSymbol('#'));
        self::assertFalse($symbols->hasSymbol('V'));
        self::assertTrue($symbols->hasValue(4));
        self::assertFalse($symbols->hasValue(40));
    }

    public function testExceptionMissingSymbol(): void
    {
        $symbols = new Base62Symbols();
        $this->expectException(InvalidArgumentException::class);
        $symbols->getSymbol(100);
    }

    public function testExceptionMissingValue(): void
    {
        $symbols = new Base62Symbols();
        $this->expectException(InvalidArgumentException::class);
        $symbols->getValue('#');
    }
}
