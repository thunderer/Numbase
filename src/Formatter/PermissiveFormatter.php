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
            return implode('', array_map(array($symbols, 'getSymbol'), $digits));
            }
        catch(\InvalidArgumentException $e)
            {
            return implode($this->separator, $digits);
            }
        }
    }
