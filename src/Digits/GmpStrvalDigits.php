<?php
namespace Thunder\Numbase\Digits;

use Thunder\Numbase\DigitsInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class GmpStrvalDigits implements DigitsInterface
    {
    private $symbols;

    public function __construct(SymbolsInterface $symbols)
        {
        $this->symbols = $symbols;
        }

    public function getDigits($source, $sourceBase, $targetBase)
        {
        if($sourceBase < 2 || $targetBase < 2 || $sourceBase > 62 || $targetBase > 62)
            {
            $msg = 'Invalid source or target base, must be an integer between 2 and 62!';
            throw new \InvalidArgumentException(sprintf($msg));
            }

        $source = (string)$source;
        if(0 === mb_strlen($source))
            {
            $msg = 'How about a non-empty string?';
            throw new \InvalidArgumentException($msg);
            }

        $digits = str_split((string)gmp_strval(gmp_init($source, $sourceBase), $targetBase), 1);
        $digits = array_map(array($this->symbols, 'getValue'), $digits);

        return array_map('strval', $digits);
        }
    }
