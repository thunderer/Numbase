# Numbase

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
