<?php
namespace Thunder\Numbase\Symbols;

use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
abstract class AbstractSymbols implements SymbolsInterface
{
    protected $symbols = array();
    protected $reverseSymbols = array();

    public function getSymbol($value)
    {
        if(false === array_key_exists($value, $this->symbols)) {
            throw new \InvalidArgumentException(sprintf('No symbol matching value %s!', $value));
        }

        return $this->symbols[$value];
    }

    public function getValue($symbol)
    {
        if(false === array_key_exists($symbol, $this->reverseSymbols)) {
            throw new \InvalidArgumentException(sprintf('No value matching symbol %s!', $symbol));
        }

        return $this->reverseSymbols[$symbol];
    }

    public function hasSymbol($symbol)
    {
        return in_array($symbol, $this->symbols, true);
    }

    public function hasValue($value)
    {
        return in_array($value, $this->reverseSymbols, true);
    }
}
