<?php

namespace Podrecznikomat\IsbnApi\Helpers;

class IsbnNormalizer
{
    /**
     * @param string $isbn
     * @return string
     */
    public static function normalize(string $isbn): string
    {
        return preg_replace('/[^0-9X]/i', '', strtoupper($isbn));
    }
}