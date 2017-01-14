<?php
namespace Thunder\Numbase\Symbols;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Base10Symbols extends AbstractSymbols
{
    public function __construct()
    {
        $this->symbols = str_split('0123456789');
        $this->reverseSymbols = array_flip($this->symbols);
    }
}
