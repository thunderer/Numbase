<?php
namespace Thunder\Numbase\Symbols;

use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
abstract class AbstractSymbols implements SymbolsInterface
{
    /** @var array<int,string> */
    protected iterable $symbols = [];
    /** @var array<string,int> */
    protected iterable $reverseSymbols = [];

    public function getSymbol(int $value): string
    {
        if(false === array_key_exists($value, $this->symbols)) {
            throw new \InvalidArgumentException(sprintf('No symbol matching value %s!', $value));
        }

        return $this->symbols[$value];
    }

    public function getValue(string $symbol): int
    {
        if(false === array_key_exists($symbol, $this->reverseSymbols)) {
            throw new \InvalidArgumentException(sprintf('No value matching symbol %s!', $symbol));
        }

        return $this->reverseSymbols[$symbol];
    }

    public function hasSymbol(string $symbol): bool
    {
        return in_array($symbol, $this->symbols, true);
    }

    public function hasValue(int $value): bool
    {
        return in_array($value, $this->reverseSymbols, true);
    }
}
