<?php
namespace Thunder\Numbase;

use Thunder\Numbase\Converter\GmpConverter;
use Thunder\Numbase\Formatter\StrictFormatter;
use Thunder\Numbase\Symbols\Base62Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Numbase
    {
    private $formatter;
    private $digits;

    public function __construct(ConverterInterface $digits, FormatterInterface $formatter)
        {
        $this->formatter = $formatter;
        $this->digits = $digits;
        }

    public static function createDefault(SymbolsInterface $symbols = null)
        {
        $symbols = $symbols ?: new Base62Symbols();

        return new self(new GmpConverter($symbols), new StrictFormatter($symbols));
        }

    /**
     * Converts number with given base to another base. Do not forget to set
     * proper symbols set. Result type depends on the formatter implementation.
     *
     * @param int|string $number Number to convert
     * @param int $fromBase Source number base
     * @param int $toBase Target number base
     *
     * @return mixed Depends on formatter
     */
    public function convert($number, $fromBase, $toBase)
        {
        $signed = false;
        $number = (string)$number;
        if($number && '-' === $number[0])
            {
            $signed = true;
            $number = substr($number, 1);
            }

        $digits = $this->digits->getDigits($number, $fromBase, $toBase);

        return $this->formatter->format($digits, $signed);
        }
    }
