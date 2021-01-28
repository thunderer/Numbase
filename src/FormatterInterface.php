<?php
namespace Thunder\Numbase;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
interface FormatterInterface
{
    /**
     * Formats computed digits to a final result.
     *
     * @param int[] $digits
     *
     * @return mixed
     */
    public function format(array $digits, bool $signed);
}
