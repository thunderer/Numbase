<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StrictFormatter implements FormatterInterface
{
    private SymbolsInterface $symbols;

    public function __construct(SymbolsInterface $symbols)
    {
        $this->symbols = $symbols;
    }

    public function format(array $digits, bool $signed)
    {
        return ($signed ? '-' : '').implode('', array_map(function(int $digit) { return $this->symbols->getSymbol($digit); }, $digits));
    }
}
