<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StrictFormatter implements FormatterInterface
    {
    public function format(array $digits, SymbolsInterface $symbols)
        {
        $symbols = array_map(function($item) use($symbols) {
            return $symbols->getSymbol(gmp_strval($item));
            }, $digits);

        return implode('', $symbols);
        }
    }
