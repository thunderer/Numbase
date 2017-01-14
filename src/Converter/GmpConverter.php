<?php
namespace Thunder\Numbase\Converter;

use Thunder\Numbase\ConverterInterface;
use Thunder\Numbase\SymbolsInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class GmpConverter implements ConverterInterface
{
    private $symbols;

    public function __construct(SymbolsInterface $symbols)
    {
        $this->symbols = $symbols;
    }

    public function convert($source, $sourceBase, $targetBase)
    {
        if($sourceBase < 2 || $targetBase < 2) {
            throw new \InvalidArgumentException(sprintf('Invalid source or target base, must be an integer greater than one!'));
        }

        $source = (string)$source;
        if('' === $source) {
            throw new \InvalidArgumentException('How about a non-empty string?');
        }

        return $this->computeBaseNDigits($this->convertToBase10($source, $sourceBase), $targetBase);
    }

    private function convertToBase10($source, $sourceBase)
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

    private function computeBaseNDigits($number, $targetBase)
    {
        $digits = array();
        $length = $this->computeBaseNLength($number, $targetBase);

        for($i = 0; $i < $length; $i++) {
            $pow = gmp_pow($targetBase, $length - $i - 1);
            $div = gmp_div($number, $pow, GMP_ROUND_ZERO);
            $number = gmp_sub($number, gmp_mul($div, $pow));
            $digits[] = $div;
        }

        return array_map('gmp_strval', $digits);
    }

    private function computeBaseNLength($number, $targetBase)
    {
        $digits = 0;

        while(gmp_cmp($number, gmp_pow($targetBase, $digits)) >= 0) {
            $digits++;
        }

        return $digits ?: 1;
    }
}
