<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface SymbolsInterface
{
    /** Returns symbol matching given value. */
    public function getSymbol(int $value): string;

    /** Returns value matching given symbol. */
    public function getValue(string $symbol): int;

    /** Tests whether current set contains given symbol. */
    public function hasSymbol(string $symbol): bool;

    /** Tests whether current set contains given value. */
    public function hasValue(int $value): bool;
}
