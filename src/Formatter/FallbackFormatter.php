<?php
namespace Thunder\Numbase\Formatter;

use mysql_xdevapi\TableInsert;
use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FallbackFormatter implements FormatterInterface
{
    private $symbols;
    /** @var string */
    private $separator;

    /** @param string $separator */
    public function __construct(SymbolsInterface $symbols, $separator)
    {
        $this->symbols = $symbols;
        $this->separator = $separator;
    }

    public function format(array $digits, bool $signed)
    {
        $sign = $signed ? '-' : '';

        try {
            return $sign.implode('', array_map(function(int $digit) { return $this->symbols->getSymbol($digit); }, $digits));
        } catch(\InvalidArgumentException $e) {
            return $sign.implode($this->separator, $digits);
        }
    }
}
