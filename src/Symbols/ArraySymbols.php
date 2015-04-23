<?php
namespace Thunder\Numbase\Symbols;

use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArraySymbols extends AbstractSymbols implements SymbolsInterface
    {
    public function __construct(array $array)
        {
        $this->symbols = $array;
        $this->reverseSymbols = array_flip($this->symbols);
        }
    }
