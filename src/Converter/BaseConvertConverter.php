<?php
namespace Thunder\Numbase\Converter;

use Thunder\Numbase\ConverterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BaseConvertConverter implements ConverterInterface
    {
    private $symbols;

    public function __construct(SymbolsInterface $symbols)
        {
        $this->symbols = $symbols;
        }

    public function getDigits($source, $sourceBase, $targetBase)
        {
        if($sourceBase < 2 || $targetBase < 2 || $sourceBase > 36 || $targetBase > 36)
            {
            $msg = 'Invalid source or target base, must be an integer between 2 and 36!';
            throw new \InvalidArgumentException(sprintf($msg));
            }

        $source = (string)$source;
        if(0 === mb_strlen($source))
            {
            $msg = 'How about a non-empty string?';
            throw new \InvalidArgumentException($msg);
            }

        $digits = str_split((string)base_convert($source, $sourceBase, $targetBase), 1);

        // base_convert() returns lowercase characters so they need to be
        // uppercased because lowercased come in latter
        $digits = array_map('strtoupper', $digits);
        $digits = array_map(array($this->symbols, 'getValue'), $digits);

        return array_map('strval', $digits);
        }
    }
