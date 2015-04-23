<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class PermissiveFormatter implements FormatterInterface
    {
    private $separator;

    public function __construct($separator)
        {
        $this->separator = $separator;
        }

    public function format(array $digits, SymbolsInterface $symbols)
        {
        try
            {
            $symbols = array_map(function($item) use($symbols) {
                return $symbols->getSymbol(gmp_strval($item));
                }, $digits);

            return implode('', $symbols);
            }
        catch(\InvalidArgumentException $e)
            {
            return implode($this->separator, $digits);
            }
        }
    }
