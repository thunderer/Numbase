<?php
namespace Thunder\Numbase\Converter;

use Thunder\Numbase\ConverterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BaseConvertConverter implements ConverterInterface
{
    private SymbolsInterface $symbols;

    public function __construct(SymbolsInterface $symbols)
    {
        $this->symbols = $symbols;
    }

    public function convert(string $number, int $sourceBase, int $targetBase): array
    {
        if($sourceBase < 2 || $targetBase < 2 || $sourceBase > 36 || $targetBase > 36) {
            $msg = 'Invalid source or target base, must be an integer between 2 and 36!';
            throw new \InvalidArgumentException(sprintf($msg));
        }

        if('' === $number) {
            throw new \InvalidArgumentException('How about a non-empty string?');
        }

        $digits = str_split(base_convert($number, $sourceBase, $targetBase), 1);

        // base_convert() returns lowercase characters so they need to be
        // uppercased because lowercased come in latter
        $symbolToValue = function(string $symbol): int { return $this->symbols->getValue($symbol); };
        $digitToUppercase = function(string $digit): string { return strtoupper($digit); };

        return array_map($symbolToValue, array_map($digitToUppercase, $digits));
    }
}
