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
    public function testBase62Symbols()
    {
        $symbols = new Base62Symbols();

        $this->assertSame(0, $symbols->getValue('0'));
        $this->assertSame('0', $symbols->getSymbol(0));
        $this->assertTrue($symbols->hasSymbol('z'));
        $this->assertFalse($symbols->hasSymbol('#'));
        $this->assertTrue($symbols->hasValue(10));
        $this->assertFalse($symbols->hasValue(100));
    }

    public function testBase10Symbols()
    {
        $symbols = new Base10Symbols();

        $this->assertSame(0, $symbols->getValue('0'));
        $this->assertSame('0', $symbols->getSymbol(0));
        $this->assertTrue($symbols->hasSymbol('7'));
        $this->assertFalse($symbols->hasSymbol('C'));
        $this->assertTrue($symbols->hasValue(9));
        $this->assertFalse($symbols->hasValue(100));
    }

    public function testArraySymbols()
    {
        $symbols = new ArraySymbols(array(2 => '!', 4 => '@', 6 => '#'));

        $this->assertSame(2, $symbols->getValue('!'));
        $this->assertSame('@', $symbols->getSymbol(4));
        $this->assertTrue($symbols->hasSymbol('#'));
        $this->assertFalse($symbols->hasSymbol('V'));
        $this->assertTrue($symbols->hasValue(4));
        $this->assertFalse($symbols->hasValue(5));
    }

    public function testStringSymbols()
    {
        $symbols = new StringSymbols('!@#$%^&*()');

        $this->assertSame(2, $symbols->getValue('#'));
        $this->assertSame('(', $symbols->getSymbol(8));
        $this->assertTrue($symbols->hasSymbol('#'));
        $this->assertFalse($symbols->hasSymbol('V'));
        $this->assertTrue($symbols->hasValue(4));
        $this->assertFalse($symbols->hasValue(40));
    }

    public function testExceptionMissingSymbol()
    {
        $symbols = new Base62Symbols();
        $this->expectException(InvalidArgumentException::class);
        $symbols->getSymbol('#');
    }

    public function testExceptionMissingValue()
    {
        $symbols = new Base62Symbols();
        $this->expectException(InvalidArgumentException::class);
        $symbols->getValue('#');
    }
}
