# Numbase

[![Build Status](https://travis-ci.org/thunderer/Numbase.png?branch=master)](https://travis-ci.org/thunderer/Numbase)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d68bec1a-f549-470a-ab71-0c00f09692a3/mini.png)](https://insight.sensiolabs.com/projects/d68bec1a-f549-470a-ab71-0c00f09692a3)
[![License](https://poser.pugx.org/thunderer/numbase/license.svg)](https://packagist.org/packages/thunderer/numbase)
[![Latest Stable Version](https://poser.pugx.org/thunderer/numbase/v/stable.svg)](https://packagist.org/packages/thunderer/numbase)
[![Dependency Status](https://www.versioneye.com/user/projects/5539612f1d2989f7ee00000b/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5539612f1d2989f7ee00000b)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thunderer/Numbase/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Numbase/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/thunderer/Numbase/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Numbase/?branch=master)
[![Code Climate](https://codeclimate.com/github/thunderer/Numbase/badges/gpa.svg)](https://codeclimate.com/github/thunderer/Numbase)

Numbase easily converts numbers between arbitrary bases.

## Requirements

No required dependencies, only PHP >=5.3

## Installation

This library is available on Packagist under alias `thunderer/numbase`. Act accordingly.

## Usage

The Simplest Path(TM):

```php
use Thunder\Numbase\Numbase;

$numbase = Numbase::createDefault();

assert('F' === $numbase->convert(15, 10, 16));
assert('20' === $numbase->convert(64000, 10, 32000));
```

But there are also other clever things you can do, for example:

Convert to a different set of symbols:

```php
$numbase = new Numbase(new GmpDigits(new Base10Symbols()), new StrictFormatter(new StringSymbols('!@#$%^&*()')));

assert('#!' === $numbase->convert('20', 10, 10));
assert('-$!' === $numbase->convert('-30', 10, 10));
```

Get array of digit values rather than final number (for bases too large for any symbol set), courtesy of `ArrayFormatter`:

```php
$numbase = new Numbase(new GmpDigits(new Base62Symbols()), new ArrayFormatter());

assert(array('10', '61', '53', '3', '51', '60', '10') === $numbase->convert('10000000000000', 10, 99));
```

## Internals

Numbase is built upon several concepts:

* **digits** that convert numbers to array of numbers of digits to form target number,
* **formatters** that take those arrays and return final numbers,
* **symbols** used in digits to check symbols values and to get digits symbols in formatters.

There are several implementations of each concept bundled with this library, for example:

* digits:
  * **GmpDigits**: can convert any integer between any base greater than 2, uses `gmp_*()` functions,
  * **GmpStrvalDigits**: uses `gmp_strval()` and can convert between bases 2 and 62,
  * **BaseConvertDigits**: uses `base_convert()` and can convert between bases 2 and 32,
* formatters:
  * **ArrayFormatter**: returns raw array of digits numbers,
  * **StrictFormatter**: returns target number as string, throws an exception when digit is not found in symbols set,
  * **PermissiveFormatter**: returns target number as string, returns imploded string separated by separator when any digit is not found is symbols set,
* symbols:
  * **ArraySymbols**: takes associative array value => symbol,
  * **Base62Symbols**: contains alphanumeric set of symbols 0-9A-Za-z up to base 62,
  * **StringSymbols**: takes string and splits it assigning consecutive values to each character.

The named constructor `Numbase::createDefault()` uses `GmpDigits`, `StrictFormatter` and `Base62Symbols` as defaults.

## License

See LICENSE file in the main directory of this library.
