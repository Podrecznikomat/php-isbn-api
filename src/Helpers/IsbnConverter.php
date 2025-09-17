<?php

namespace Podrecznikomat\IsbnApi\Helpers;

use Podrecznikomat\IsbnApi\Exceptions\InvalidIsbnException;

class IsbnConverter
{
    /**
     * @param string $isbn10
     * @return string
     * @throws InvalidIsbnException
     */
    public static function isbn10to13(string $isbn10): string
    {
        $isbn10 = IsbnNormalizer::normalize($isbn10);
        if (strlen($isbn10) !== 10) {
            throw new InvalidIsbnException("Invalid ISBN-10 format");
        }

        $core = substr($isbn10, 0, 9);
        $prefix = '978';
        $isbn13Body = $prefix . $core;

        $checksum = 0;
        for ($i = 0; $i < strlen($isbn13Body); $i++) {
            $digit = (int)$isbn13Body[$i];
            $checksum += ($i % 2 === 0) ? $digit : $digit * 3;
        }
        $checksum = (10 - ($checksum % 10)) % 10;

        return $isbn13Body . $checksum;
    }

    /**
     * @param string $isbn13
     * @return string
     * @throws InvalidIsbnException
     */
    public static function isbn13to10(string $isbn13): string
    {
        $isbn13 = IsbnNormalizer::normalize($isbn13);
        if (strlen($isbn13) !== 13 || !str_starts_with($isbn13, '978')) {
            throw new InvalidIsbnException("Invalid ISBN-13 format or not convertible to ISBN-10");
        }

        $core = substr($isbn13, 3, 9);
        $checksum = 0;
        for ($i = 0; $i < strlen($core); $i++) {
            $checksum += ((int)$core[$i]) * ($i + 1);
        }

        $checksum = $checksum % 11;
        $checksumChar = ($checksum === 10) ? 'X' : (string)$checksum;

        return $core . $checksumChar;
    }
}