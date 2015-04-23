<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class DigitsFormatter implements FormatterInterface
    {
    public function format(array $digits, SymbolsInterface $symbols)
        {
        return $digits;
        }
    }
