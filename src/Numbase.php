<?php
namespace Thunder\Numbase;

use Thunder\Numbase\Digits\GmpDigits;
use Thunder\Numbase\Formatter\PermissiveFormatter;
use Thunder\Numbase\Symbols\Base62Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Numbase
    {
    private $formatter;
    private $digits;

    public function __construct(DigitsInterface $digits, FormatterInterface $formatter)
        {
        $this->formatter = $formatter;
        $this->digits = $digits;
        }

    public static function createDefault(SymbolsInterface $symbols = null)
        {
        $symbols = $symbols ?: new Base62Symbols();

        return new self(new GmpDigits($symbols), new PermissiveFormatter($symbols, ':'));
        }

    /**
     * Converts number with given base to another base. Do not forget to set
     * proper symbols set. Result type depends on the formatter implementation.
     *
     * @param int|string $source Number to convert
     * @param int $sourceBase Source number base
     * @param int $targetBase Target number base
     *
     * @return mixed Depends on formatter
     */
    public function convert($source, $sourceBase, $targetBase)
        {
        $signed = false;
        $source = (string)$source;
        if($source && '-' === $source[0])
            {
            $signed = true;
            $source = substr($source, 1);
            }

        $digits = $this->digits->getDigits($source, $sourceBase, $targetBase);

        return $this->formatter->format($digits, $signed);
        }
    }
