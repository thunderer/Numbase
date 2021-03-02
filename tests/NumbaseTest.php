<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Converter\GmpConverter;
use Thunder\Numbase\Formatter\ArrayFormatter;
use Thunder\Numbase\Numbase;
use Thunder\Numbase\Symbols\ArraySymbols;
use Thunder\Numbase\Symbols\Base62Symbols;
use Thunder\Numbase\Symbols\StringSymbols;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class NumbaseTest extends TestCase
{
    /** @dataProvider provideNumbase */
    public function testNumbase(Numbase $numbase, $source, $from, $to, $result)
    {
        self::assertSame($result, $numbase->convert($source, $from, $to));

        if(false === strpos($result, ':')) {
            self::assertSame($source, $numbase->convert($result, $to, $from));
        }
    }

    public function provideNumbase()
    {
        $symbols = '0123456789'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'abcdefghijklmnopqrstuvwxyz';
        $numbases = array(
            array(Numbase::createDefault()), // default base62 symbols
            array(Numbase::createDefault(new StringSymbols($symbols))),
            array(Numbase::createDefault(new ArraySymbols(str_split($symbols, 1)))),
        );
        $numbers = array(
            array(gmp_strval(gmp_pow(10, 9), 10), 10, 1000000000, '10'),
            array(gmp_strval(gmp_pow(10, 1000), 10), 10, 100, '1'.str_pad('', 500, '0', STR_PAD_RIGHT)),
            array('10000000000000000000000', 10, 100, '100000000000'),
            array('15', 10, 16, 'F'),
            array('zz', 62, 10, '3843'),
            array('3843', 10, 62, 'zz'),
            array('-3843', 10, 62, '-zz'),
            array('100000', 10, 62, 'Q0u'),
            array('3843', 10, 16, 'F03'),
            array('65', 10, 2, '1000001'),
            array('1', 10, 10, '1'),
            array('0', 16, 2, '0'),
            array('64000', 10, 32000, '20'),
        );

        $result = array();
        foreach($numbers as $number) {
            foreach($numbases as $numbase) {
                $result[] = array_merge($numbase, $number);
            }
        }

        return $result;
    }

    /**
     * Want to test arbitrary number ranges? Tweak range() parameters in data
     * provider and you're good to go. Defaults are -1..1 to not artificially
     * boost number of tests.
     *
     * @dataProvider provideLoop
     */
    public function testLoop(int $num): void
    {
        $base62 = Numbase::createDefault();
        self::assertSame((string)$num, $base62->convert($base62->convert($num, 10, 62), 62, 10));
    }

    public function provideLoop(): array
    {
        return array_map(fn($item) => [$item], range(-1, 1));
    }

    public function testOtherFormatters(): void
    {
        $array = new Numbase(new GmpConverter(new Base62Symbols()), new ArrayFormatter());
        self::assertSame(array(-1, 0), $array->convert(-10, 10, 10));
    }

    public function testExceptionOnInvalidSourceBase(): void
    {
        $numbase = Numbase::createDefault();
        $this->expectException(InvalidArgumentException::class);
        $numbase->convert(10, 1, 16);
    }

    public function testExceptionOnInvalidTargetBase(): void
    {
        $numbase = Numbase::createDefault();
        $this->expectException(InvalidArgumentException::class);
        $numbase->convert(10, 10, -20);
    }

    public function testExceptionOnEmptyNumber(): void
    {
        $numbase = Numbase::createDefault();
        $this->expectException(InvalidArgumentException::class);
        $numbase->convert('', 10, 10);
    }
}
