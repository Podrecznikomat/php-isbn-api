<?php

namespace Podrecznikomat\IsbnApi\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Podrecznikomat\IsbnApi\Exceptions\IsbnApiNotFoundException;
use Podrecznikomat\IsbnApi\Object\Book;

class GoogleBooks implements ApiInterface
{
    protected string $baseUrl = 'https://www.googleapis.com/books/v1/volumes';

    public function __construct(protected Client $client)
    {
    }

    /**
     * @param string $isbn
     * @return Book
     * @throws IsbnApiNotFoundException
     * @throws GuzzleException
     */
    public function getBookByIsbn(string $isbn): Book
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'q' => 'isbn:' . $isbn
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if(empty($data['items'][0]['volumeInfo'])) {
            throw new IsbnApiNotFoundException("Book not found in Google Books API.");
        }

        $info = $data['items'][0]['volumeInfo'];

        $title = $info['title'] ?? '';
        $subtitle = $info['subtitle'] ?? null;
        $authors = $info['authors'] ?? [];
        $publisher = $info['publisher'] ?? '';
        $publishedDate = $info['publishedDate'] ?? null;
        $language = $info['language'] ?? null;
        $subjects = $info['categories'] ?? [];
        $edition = null;

        return new Book(
            $isbn,
            $title,
            $subtitle,
            $authors,
            $publisher,
            $publishedDate,
            $language,
            $subjects,
            $edition
        );
    }
}