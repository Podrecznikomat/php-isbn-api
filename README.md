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

This software is free to use, modify, and distribute for non-commercial purposes. You may not sell this software or any derivative works. Please credit Podrecznikomat as the original authors. For any questions, contact Patryk Molenda at patryk.fr.molenda@gmail.com.

## Contact

Author: Patryk Molenda
Email: patryk.fr.molenda@gmail.com
