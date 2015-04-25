<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface DigitsInterface
    {
    /**
     * Converts number from source to target base and return digits array
     *
     * @param string $number
     * @param int $sourceBase
     * @param int $targetBase
     *
     * @return array
     */
    public function getDigits($number, $sourceBase, $targetBase);
    }