<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class FallbackFormatter implements FormatterInterface
    {
    private $symbols;
    private $separator;

    public function __construct(SymbolsInterface $symbols, $separator)
        {
        $this->symbols = $symbols;
        $this->separator = $separator;
        }

    public function format(array $digits, $signed)
        {
        $sign = $signed ? '-' : '';
        try
            {
            return $sign.implode('', array_map(array($this->symbols, 'getSymbol'), $digits));
            }
        catch(\InvalidArgumentException $e)
            {
            return $sign.implode($this->separator, $digits);
            }
        }
    }
