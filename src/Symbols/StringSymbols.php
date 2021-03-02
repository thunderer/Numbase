<?php
namespace Thunder\Numbase\Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class StringSymbols extends AbstractSymbols
{
    /** @param string $string */
    public function __construct($string)
    {
        $this->symbols = str_split($string, 1);
        $this->reverseSymbols = array_flip($this->symbols);
    }
}
