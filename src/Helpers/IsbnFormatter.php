<?php

namespace Podrecznikomat\IsbnApi\Helpers;

use Podrecznikomat\IsbnApi\Exceptions\InvalidIsbnException;

class IsbnFormatter
{
    /**
     * @param string $isbn
     * @return string
     * @throws InvalidIsbnException
     */
    public static function format(string $isbn): string
    {
        $normalizedIsbn = IsbnNormalizer::normalize($isbn);
        if (strlen($normalizedIsbn) === 10) {
            return substr($normalizedIsbn, 0, 1) . '-' .
                substr($normalizedIsbn, 1, 3) . '-' .
                substr($normalizedIsbn, 4, 5) . '-' .
                substr($normalizedIsbn, 9, 1);
        } elseif (strlen($normalizedIsbn) === 13) {
            return substr($normalizedIsbn, 0, 3) . '-' .
                substr($normalizedIsbn, 3, 1) . '-' .
                substr($normalizedIsbn, 4, 4) . '-' .
                substr($normalizedIsbn, 8, 4) . '-' .
                substr($normalizedIsbn, 12, 1);
        } else {
            throw new InvalidIsbnException("Invalid ISBN format");
        }
    }
}