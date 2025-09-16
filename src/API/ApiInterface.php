<?php

namespace Podrecznikomat\IsbnApi\API;

use Podrecznikomat\IsbnApi\Object\Book;

interface ApiInterface
{
    /**
     * @param string $isbn
     * @return Book
     */
    public function getBookByIsbn(string $isbn): Book;
}