<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface SymbolsInterface
    {
    /**
     * Returns symbol matching given value.
     *
     * @param $value
     *
     * @return string
     */
    public function getSymbol($value);

    /**
     * Returns value matching given symbol.
     *
     * @param $symbol
     *
     * @return int
     */
    public function getValue($symbol);

    /**
     * Tests whether current set contains given symbol.
     *
     * @param $symbol
     *
     * @return bool
     */
    public function hasSymbol($symbol);

    /**
     * Tests whether current set contains given value.
     *
     * @param $value
     *
     * @return bool
     */
    public function hasValue($value);
    }
