<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Formatter\PermissiveFormatter;
use Thunder\Numbase\Formatter\StrictFormatter;
use Thunder\Numbase\Numbase;
use Thunder\Numbase\Symbols\ArraySymbols;
use Thunder\Numbase\Symbols\Base62Symbols;
use Thunder\Numbase\Symbols\StringSymbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class NumbaseTest extends \PHPUnit_Framework_TestCase
    {
    /**
     * @dataProvider provideNumbase
     */
    public function testNumbase($source, $from, $to, $result)
        {
        $symbols = ''
            .'0123456789'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            .'abcdefghijklmnopqrstuvwxyz'
            .'';

        $formatter = new PermissiveFormatter(':');
        $base62 = new Numbase(new Base62Symbols(), $formatter);
        $string = new Numbase(new StringSymbols($symbols), $formatter);
        $array = new Numbase(new ArraySymbols(str_split($symbols, 1)), $formatter);

        $this->assertSame($result, $base62->convert($source, $from, $to));
        $this->assertSame($result, $string->convert($source, $from, $to));
        $this->assertSame($result, $array->convert($source, $from, $to));

        if(false === strpos($result, ':'))
            {
            $this->assertSame($source, $base62->convert($result, $to, $from));
            $this->assertSame($source, $string->convert($result, $to, $from));
            $this->assertSame($source, $array->convert($result, $to, $from));
            }
        }

    public function provideNumbase()
        {
        return array(
            array(gmp_strval(gmp_pow(10, 9), 10), 10, 1000000000, '10'),
            array(gmp_strval(gmp_pow(10, 1000), 10), 10, 100, '1'.str_pad('', 500, '0', STR_PAD_RIGHT)),
            array(gmp_strval(gmp_pow(10, 38), 10), 10, 99, '1:20:82:19:36:27:27:76:96:60:86:61:74:24:84:24:79:72:19:1'),
            array('10000000000000000000000', 10, 100, '100000000000'),
            array('654321', 10, 100, '65:43:21'),
            array('15', 10, 16, 'F'),
            array('zz', 62, 10, '3843'),
            array('3843', 10, 62, 'zz'),
            array('-3843', 10, 62, '-zz'),
            array('100000', 10, 62, 'Q0u'),
            array('3843', 10, 16, 'F03'),
            array('65', 10, 2, '1000001'),
            array('1', 10, 10, '1'),
            array('0', 16, 2, '0'),
            );
        }

    /**
     * Want to test arbitrary number ranges? Tweak range() parameters in data
     * provider and you're good to go. Defaults are 0..1 to not artificially
     * boost number of tests.
     *
     * @dataProvider provideLoop
     */
    public function testLoop($num)
        {
        $base62 = new Numbase(new Base62Symbols(), new PermissiveFormatter(':'));
        $this->assertSame((string)$num, $base62->convert($base62->convert($num, 10, 62), 62, 10));
        }

    public function provideLoop()
        {
        return array_map(function($item) {
            return array($item);
            }, range(-1, 1));
        }

    public function testExceptionOnInvalidSourceBase()
        {
        $numbase = new Numbase(new Base62Symbols(), new StrictFormatter());
        $this->setExpectedException('InvalidArgumentException');
        $numbase->convert(10, 1, 16);
        }

    public function testExceptionOnInvalidTargetBase()
        {
        $numbase = new Numbase(new Base62Symbols(), new StrictFormatter());
        $this->setExpectedException('InvalidArgumentException');
        $numbase->convert(10, 10, -20);
        }

    public function testExceptionOnEmptyNumber()
        {
        $numbase = new Numbase(new Base62Symbols(), new StrictFormatter());
        $this->setExpectedException('InvalidArgumentException');
        $numbase->convert('', 10, 10);
        }
    }
