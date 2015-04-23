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
        return implode('', array_map(array($symbols, 'getSymbol'), $digits));
        }
    }
