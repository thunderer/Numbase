<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface FormatterInterface
    {
    /**
     * Formats computed digits to a final result.
     *
     * @param array $digits
     * @param SymbolsInterface $symbols
     *
     * @return mixed
     */
    public function format(array $digits, SymbolsInterface $symbols);
    }
