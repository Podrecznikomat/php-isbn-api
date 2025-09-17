<?php

namespace Podrecznikomat\IsbnApi\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Podrecznikomat\IsbnApi\Exceptions\IsbnApiInvalidResponseException;
use Podrecznikomat\IsbnApi\Object\Book;

class OpenLibrary implements ApiInterface
{
    protected string $baseUrl = 'https://openlibrary.org/api/books';

    public function __construct(protected Client $client)
    {
    }

    /**
     * @param string $isbn
     * @return Book
     * @throws GuzzleException
     * @throws IsbnApiInvalidResponseException
     */
    public function getBookByIsbn(string $isbn): Book
    {
        $response = $this->client->get($this->baseUrl, [
            'query' => [
                'bibkeys' => 'ISBN:' . $isbn,
                'format' => 'json',
                'jscmd' => 'data'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $bookData = $data['ISBN:' . $isbn] ?? null;

        if (!$bookData) {
            throw new IsbnApiInvalidResponseException("No book found for ISBN: {$isbn}");
        }

        $title = $bookData['title'] ?? '';
        $subtitle = $bookData['subtitle'] ?? null;

        $authors = [];
        if (!empty($bookData['authors'])) {
            foreach ($bookData['authors'] as $author) {
                $authors[] = $author['name'];
            }
        }

        $publisher = $bookData['publishers'][0]['name'] ?? '';
        $publishedDate = $bookData['publish_date'] ?? null;
        $language = null; // OpenLibrary doesn't always provide language info in this endpoint

        $subjects = [];
        if (!empty($bookData['subjects'])) {
            foreach ($bookData['subjects'] as $subject) {
                $subjects[] = $subject['name'];
            }
        }

        $edition = $bookData['number_of_pages'] ?? null; // Not a true edition, but can be used as placeholder

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