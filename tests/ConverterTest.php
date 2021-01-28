<?php
namespace Thunder\Numbase\Tests;

use Thunder\Numbase\Converter\BaseConvertConverter;
use Thunder\Numbase\Converter\GmpConverter;
use Thunder\Numbase\Converter\GmpStrvalConverter;
use Thunder\Numbase\Symbols\Base62Symbols;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ConverterTest extends TestCase
{
    public function testGmpConverter(): void
    {
        $digits = new GmpConverter(new Base62Symbols());

        self::assertSame($this->colonSeparatedIntegers('1:20:82:19:36:27:27:76:96:60:86:61:74:24:84:24:79:72:19:1'), $digits->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 99));
        self::assertSame($this->digitsString('100000000000'), $digits->convert('10000000000000000000000', 10, 100));
    }

    public function testGmpStrvalDigits(): void
    {
        $converter = new GmpStrvalConverter(new Base62Symbols());

        self::assertSame($this->colonSeparatedIntegers('2:17:59:32:31:60:4:18:0:7:60:7:54:25:34:11:18:35:1:58:47:14'), $converter->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 62));
        self::assertSame($this->colonSeparatedIntegers('41:5:3:36:6:5:0:0:0:0:0:0:0:0:0:0:0'), $converter->convert('10000000000000000000000', 10, 20));
    }

    public function testGmpStrvalExceptionOnInvalidSourceBase(): void
    {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('10', 1, 10);
    }

    public function testGmpStrvalExceptionOnInvalidTargetBase(): void
    {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('10', 10, 63);
    }

    public function testGmpStrvalExceptionOnEmptyNumber(): void
    {
        $converter = new GmpStrvalConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('', 10, 20);
    }

    public function testBaseConvertDigits(): void
    {
        $converter = new BaseConvertConverter(new Base62Symbols());

        self::assertSame($this->colonSeparatedIntegers('4:16:12:8:33:15:15:6:34:11:20:0:20:28:32:4:24:0:32:4:12:16:12:28:32'), $converter->convert(gmp_strval(gmp_pow(10, 38), 10), 10, 36));
        self::assertSame($this->digitsString('100000000000'), $converter->convert('100000000000', 10, 10));
        self::assertSame($this->colonSeparatedIntegers('3:18:2:10:0:0:0:0:0'), $converter->convert('100000000000', 10, 20));
    }

    public function testBaseConvertExceptionOnInvalidSourceBase(): void
    {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('10', 40, 10);
    }

    public function testBaseConvertExceptionOnInvalidTargetBase(): void
    {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('10', 10, 40);
    }

    public function testBaseConvertExceptionOnEmptyNumber(): void
    {
        $converter = new BaseConvertConverter(new Base62Symbols());
        $this->expectException(InvalidArgumentException::class);
        $converter->convert('', 10, 20);
    }

    private function colonSeparatedIntegers($string): array
    {
        return array_map('intval', explode(':', $string));
    }

    private function digitsString($string): array
    {
        return array_map('intval', str_split($string, 1));
    }
}
