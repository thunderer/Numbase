<?php
namespace Thunder\Numbase\Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class ArraySymbols extends AbstractSymbols
{
    /** @param array<int,string> $array */
    public function __construct(array $array)
    {
        $this->symbols = $array;
        $this->reverseSymbols = array_flip($this->symbols);
    }
}
