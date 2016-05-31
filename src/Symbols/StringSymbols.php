<?php
namespace Thunder\Numbase\Symbols;

use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringSymbols extends AbstractSymbols implements SymbolsInterface
{
    public function __construct($string)
    {
        $this->symbols = str_split($string, 1);
        $this->reverseSymbols = array_flip($this->symbols);
    }
}
