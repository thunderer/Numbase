<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface ConverterInterface
{
    /**
     * Converts number from source to target base and return digits array
     *
     * @return int[]
     */
    public function convert(string $number, int $sourceBase, int $targetBase): array;
}
