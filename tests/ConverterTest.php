<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Converter\BaseConvertConverter;
use Thunder\Numbase\Converter\GmpConverter;
use Thunder\Numbase\Converter\GmpStrvalConverter;
use Thunder\Numbase\Symbols\Base62Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ConverterTest extends \PHPUnit_Framework_TestCase
    {
    public function testGmpConverter()
        {
        $digits = new GmpConverter(new Base62Symbols());

        $this->assertSame(explode(':', '1:20:82:19:36:27:27:76:96:60:86:61:74:24:84:24:79:72:19:1'),
            $digits->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 99));
        $this->assertSame(str_split('100000000000', 1), $digits->convert('10000000000000000000000', 10, 100));
        }

    public function testGmpStrvalDigits()
        {
        $converter = new GmpStrvalConverter(new Base62Symbols());

        $this->assertSame(explode(':', '2:17:59:32:31:60:4:18:0:7:60:7:54:25:34:11:18:35:1:58:47:14'),
            $converter->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 62));
        $this->assertSame(explode(':', '41:5:3:36:6:5:0:0:0:0:0:0:0:0:0:0:0'),
            $converter->convert('10000000000000000000000', 10, 20));
        }

    public function testGmpStrvalExceptionOnInvalidSourceBase()
        {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('10', 1, 10);
        }

    public function testGmpStrvalExceptionOnInvalidTargetBase()
        {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('10', 10, 63);
        }

    public function testGmpStrvalExceptionOnEmptyNumber()
        {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('', 10, 20);
        }

    public function testBaseConvertDigits()
        {
        $converter = new BaseConvertConverter(new Base62Symbols());

        $this->assertSame(explode(':', '4:16:12:8:33:15:15:6:34:11:20:0:20:28:32:4:24:0:32:4:12:16:12:28:32'),
            $converter->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 36));
        $this->assertSame(str_split('100000000000', 1), $converter->convert('100000000000', 10, 10));
        $this->assertSame(explode(':', '3:18:2:10:0:0:0:0:0'), $converter->convert('100000000000', 10, 20));
        }

    public function testBaseConvertExceptionOnInvalidSourceBase()
        {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('10', 40, 10);
        }

    public function testBaseConvertExceptionOnInvalidTargetBase()
        {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('10', 10, 40);
        }

    public function testBaseConvertExceptionOnEmptyNumber()
        {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->setExpectedException('InvalidArgumentException');
        $converter->convert('', 10, 20);
        }
    }
