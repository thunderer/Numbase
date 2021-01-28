# Numbase

![Build](https://github.com/thunderer/Numbase/actions/workflows/test.yaml/badge.svg)
[![License](https://poser.pugx.org/thunderer/numbase/license.svg)](https://packagist.org/packages/thunderer/numbase)
[![Version](https://poser.pugx.org/thunderer/numbase/v/stable.svg)](https://packagist.org/packages/thunderer/numbase)

Easily convert numbers between arbitrary bases and symbol sets.

## Requirements

This library requires PHP >=5.3 (namespaces) and GMP extension (for handling large numbers exceeding PHP capabilities).

## Installation

This library is available on [Packagist](https://packagist.org/packages/thunderer/numbase) as `thunderer/numbase`.

## Usage

**The Simplest Way&trade;**

```php
use Thunder\Numbase\Numbase;

$numbase = Numbase::createDefault();

// decimal 15 to hexadecimal number
assert('F' === $numbase->convert(15, 10, 16));
// 64000 decimal to base 32000
assert('20' === $numbase->convert(64000, 10, 32000));
```

Regular usage (see Internals section for more options):

```php
use Thunder\Numbase\Numbase;

$base62 = new Base62Symbols();
$numbase = new Numbase(new GmpConverter($base62), new StrictFormatter($base62));

// decimal 15 to hexadecimal number
assert('F' === $numbase->convert(15, 10, 16));
```

**Showcase**

Convert number to and from a different set of symbols:

```php
$base10 = new Base10Symbols();
$upper = new StringSymbols('!@#$%^&*()');

$numbase = new Numbase(new GmpDigits($base10), new StrictFormatter($upper));

assert('#!' === $numbase->convert('20', 10, 10));
assert('-$!' === $numbase->convert('-30', 10, 10));

$numbase = new Numbase(new GmpDigits($upper), new StrictFormatter($base10));

assert('20' === $numbase->convert('#!', 10, 10));
assert('-30' === $numbase->convert('-$!', 10, 10));
```

Get array of digit values (for bases too large for any symbol set):

```php
$numbase = new Numbase(new GmpDigits(new Base62Symbols()), new ArrayFormatter());

// convert 10^12 to base 99:
assert(array('10', '61', '53', '3', '51', '60', '10') 
    === $numbase->convert('10000000000000', 10, 99));
```

## Internals

Numbase is built upon several concepts:

* **converters** that convert numbers to array of numbers of digits,
* **formatters** that take those arrays and return final numbers,
* **symbols** used in converters to check symbols values and to get digits symbols in formatters.

There are several implementations of each concept bundled with this library, for example:

* converters:
  * **GmpConverter**: can convert any integer between any base greater than 2, uses `gmp_*()` functions,
  * **GmpStrvalConverter**: uses `gmp_strval()` to convert between bases 2 and 62,
  * **BaseConvertConverter**: uses `base_convert()` to convert between bases 2 and 32,
* formatters:
  * **ArrayFormatter**: returns raw array of digits numbers,
  * **StrictFormatter**: returns number as string, throws exception when digit is not found in symbols set,
  * **FallbackFormatter**: returns number as string, but returns string with digit values separated by configured separator when any digit is not found in symbols set,
* symbols:
  * **ArraySymbols**: takes associative `array(value => symbol)`,
  * **Base62Symbols**: contains alphanumeric set of symbols `0-9A-Za-z up` to base 62,
  * **StringSymbols**: takes string and splits it assigning consecutive values to each character.

The named constructor `Numbase::createDefault()` uses `GmpConverter`, `StrictFormatter` and `Base62Symbols` as defaults.

## License

See LICENSE file in the main directory of this library.
