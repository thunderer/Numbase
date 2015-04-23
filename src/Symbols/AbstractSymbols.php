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
        if(!array_key_exists($value, $this->symbols))
            {
            $msg = 'No symbol matching value %s!';
            throw new \InvalidArgumentException(sprintf($msg, $value));
            }

        return $this->symbols[$value];
        }

    public function getValue($symbol)
        {
        if(!array_key_exists($symbol, $this->reverseSymbols))
            {
            $msg = 'No value matching symbol %s!';
            throw new \InvalidArgumentException(sprintf($msg, $symbol));
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
