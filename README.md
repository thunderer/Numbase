# Numbase

[![Build Status](https://travis-ci.org/thunderer/Numbase.png?branch=master)](https://travis-ci.org/thunderer/Numbase)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5235d5e3-d112-48df-bc07-d4555aef293d/mini.png)](https://insight.sensiolabs.com/projects/5235d5e3-d112-48df-bc07-d4555aef293d)
[![License](https://poser.pugx.org/thunderer/numbase/license.svg)](https://packagist.org/packages/thunderer/numbase)
[![Latest Stable Version](https://poser.pugx.org/thunderer/numbase/v/stable.svg)](https://packagist.org/packages/thunderer/numbase)
[![Dependency Status](https://www.versioneye.com/user/projects/551d5385971f7847ca000002/badge.svg?style=flat)](https://www.versioneye.com/user/projects/551d5385971f7847ca000002)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thunderer/Numbase/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Numbase/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/thunderer/Numbase/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Numbase/?branch=master)
[![Code Climate](https://codeclimate.com/github/thunderer/Numbase/badges/gpa.svg)](https://codeclimate.com/github/thunderer/Numbase)

Numbase is a small utility for converting numbers between arbitrary bases. It uses PHP GMP extension to handle big integers.

## Requirements

No required dependencies, only PHP >=5.3

## Installation

This library is available on Packagist under alias `thunderer/numbase`. Act accordingly.

## Usage

```php
use Thunder\Numbase\Numbase;
use Thunder\Numbase\Formatter\PermissiveFormatter;
use Thunder\Numbase\Symbols\Base62Symbols;

$numbase = new Numbase(new Base62Symbols(), new PermissiveFormatter());

assert('10' === $numbase->convert(16, 10, 16));
```

## License

See LICENSE file in the main directory of this library.
