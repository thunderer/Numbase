<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StrictFormatter implements FormatterInterface
{
    private $symbols;

    public function __construct(SymbolsInterface $symbols)
    {
        $this->symbols = $symbols;
    }

    public function format(array $digits, $signed)
    {
        return ($signed ? '-' : '').implode('', array_map(array($this->symbols, 'getSymbol'), $digits));
    }
}
