# Podrecznikomat ISBN API

A PHP library for retrieving book data by ISBN.

## Installation

Requires [Composer](https://getcomposer.org/).

```bash
composer require podrecznikomat/php-isbn-api
```

## Requirements
- PHP >= 8.1
- GuzzleHttp

## Quick Start

```php
use Podrecznikomat\IsbnApi\Client;
use Podrecznikomat\IsbnApi\IsbnEnum;

$client = new Client(IsbnEnum::E_ISBN_PL);
$book = $client->api()->getBookByIsbn('9788324677658');

// Access book data
echo $book->getFullTitle();
echo $book->getAuthorsAsString();
```

## Book Object Structure
- isbn
- title
- subtitle
- authors
- publisher
- publishedDate
- language
- subjects
- edition

## API Support list

- e-isbn.pl

## Tests

To run tests:

```bash
vendor/bin/phpunit tests
```

## License

Copyright (c) 2025 Podrecznikomat

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to use,
copy, modify, merge, publish, and distribute the Software within their own
projects, subject to the following conditions:

1. Attribution: Any use of the Software must give appropriate credit,
   including the name of the original author(s).
2. Non-Sale: The Software itself, in source or compiled form, may not be sold
   as a standalone product.
3. Integration: The Software may be used within commercial or non-commercial
   projects, provided the above conditions are met.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.

## Contact

Author: Patryk Molenda
Email: patryk.fr.molenda@gmail.com
