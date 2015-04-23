<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class Numbase
    {
    private $formatter;
    private $symbols;

    public function __construct(SymbolsInterface $symbols, FormatterInterface $formatter)
        {
        $this->formatter = $formatter;
        $this->symbols = $symbols;
        }

    /**
     * Converts number with given base to another base. Do not forget to set
     * proper symbols set. Result type depends on the formatter implementation.
     *
     * @param int|string $source Number to convert
     * @param int $sourceBase Source number base
     * @param int $targetBase Target number base
     *
     * @return mixed
     */
    public function convert($source, $sourceBase, $targetBase)
        {
        $base10 = $this->convertToBase10((string)$source, $sourceBase);
        $digits = $this->computeBaseNDigits($base10, $targetBase);

        return $this->formatter->format($digits, $this->symbols);
        }

    private function convertToBase10($source, $sourceBase)
        {
        $int = gmp_init(0, 10);
        $length = mb_strlen($source) - 1;

        for($i = 0; $i <= $length; $i++)
            {
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

        for($i = 0; $i < $length; $i++)
            {
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

        while(gmp_cmp($number, gmp_pow($targetBase, $digits)) != -1)
            {
            $digits++;
            }

        return $digits ?: 1;
        }
    }
