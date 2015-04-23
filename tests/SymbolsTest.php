<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Symbols\Base62Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class SymbolsTest extends \PHPUnit_Framework_TestCase
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

    public function testExceptionMissingSymbol()
        {
        $symbols = new Base62Symbols();
        $this->setExpectedException('InvalidArgumentException');
        $symbols->getSymbol('#');
        }

    public function testExceptionMissingValue()
        {
        $symbols = new Base62Symbols();
        $this->setExpectedException('InvalidArgumentException');
        $symbols->getValue('#');
        }
    }
