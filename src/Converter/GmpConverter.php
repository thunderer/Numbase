<?php
namespace Thunder\Numbase\Converter;

use Thunder\Numbase\ConverterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class GmpConverter implements ConverterInterface
{
    private SymbolsInterface $symbols;

    public function __construct(SymbolsInterface $symbols)
    {
        $this->symbols = $symbols;
    }

    public function convert(string $number, int $sourceBase, int $targetBase): array
    {
        if($sourceBase < 2 || $targetBase < 2) {
            throw new \InvalidArgumentException(sprintf('Invalid source or target base, must be an integer greater than one!'));
        }

        if('' === $number) {
            throw new \InvalidArgumentException('How about a non-empty string?');
        }

        return $this->computeBaseNDigits($this->convertToBase10($number, $sourceBase), $targetBase);
    }

    private function convertToBase10(string $source, int $sourceBase): \GMP
    {
        $int = gmp_init(0, 10);
        $length = mb_strlen($source) - 1;

        for($i = 0; $i <= $length; $i++) {
            $pow = gmp_pow($sourceBase, $length - $i);
            $mul = gmp_mul($this->symbols->getValue($source[$i]), $pow);
            $int = gmp_add($int, $mul);
        }

        return $int;
    }

    /** @return int[] */
    private function computeBaseNDigits(\GMP $number, int $targetBase): array
    {
        $digits = [];
        $length = $this->computeBaseNLength($number, $targetBase);

        for($i = 0; $i < $length; $i++) {
            $pow = gmp_pow($targetBase, $length - $i - 1);
            $div = gmp_div($number, $pow, GMP_ROUND_ZERO);
            $number = gmp_sub($number, gmp_mul($div, $pow));
            $digits[] = (int)$div;
        }

        return $digits;
    }

    private function computeBaseNLength(\GMP $number, int $targetBase): int
    {
        $digits = 0;

        while(gmp_cmp($number, gmp_pow($targetBase, $digits)) >= 0) {
            $digits++;
        }

        return $digits ?: 1;
    }
}
