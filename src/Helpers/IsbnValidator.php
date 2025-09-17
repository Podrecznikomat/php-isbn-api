<?php

namespace Podrecznikomat\IsbnApi\Helpers;

class IsbnValidator
{
    /**
     * @param string $isbn
     * @return bool
     */
    public static function isValid(string $isbn): bool
    {
        $isbn = preg_replace('/[^0-9X]/', '', strtoupper($isbn));

        if(strlen($isbn) === 10) {
            return self::isValidIsbn10($isbn);
        }

        if (strlen($isbn) === 13) {
            return self::isValidIsbn13($isbn);
        }

        return false;
    }

    /**
     * @param string $isbn
     * @return bool
     */
    private static function isValidIsbn10(string $isbn): bool
    {
        if(!preg_match('/^\d{9}[\dX]$/', $isbn)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += ((int) $isbn[$i]) * ($i + 1);
        }

        $check = $isbn[9] === "X" ? 10 : (int) $isbn[9];
        $sum += $check * 10;

        return $sum % 11 === 0;
    }

    /**
     * @param string $isbn
     * @return bool
     */
    private static function isValidIsbn13(string $isbn): bool
    {
        if (!preg_match('/^\d{13}$/', $isbn)) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int)$isbn[$i];
            $sum += $digit * ($i % 2 === 0 ? 1 : 3);
        }

        $checkDigit = (10 - ($sum % 10)) % 10;

        return $checkDigit === (int)$isbn[12];
    }
}