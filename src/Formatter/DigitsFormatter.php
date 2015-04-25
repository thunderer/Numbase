<?php
namespace Thunder\Numbase\Formatter;

use Thunder\Numbase\FormatterInterface;

/**
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class DigitsFormatter implements FormatterInterface
    {
    public function format(array $digits, $signed)
        {
        if($signed)
            {
            $digits[0] = '-'.$digits[0];
            }

        return $digits;
        }
    }
