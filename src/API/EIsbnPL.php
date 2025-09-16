<?php

namespace Podrecznikomat\IsbnApi\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Podrecznikomat\IsbnApi\Exceptions\ISBNApiInvalidResponseException;
use Podrecznikomat\IsbnApi\Object\Book;

class EIsbnPL implements ApiInterface
{
    protected string $baseUrl = 'https://e-isbn.pl/IsbnWeb/api.xml';

    /**
     * @param Client $client
     */
    public function __construct(protected Client $client)
    {
    }

    /**
     * @param string $isbn
     * @return Book
     * @throws GuzzleException
     * @throws ISBNApiInvalidResponseException
     */
    public function getBookByIsbn(string $isbn): Book
    {
        $response = $this->client->get($this->baseUrl . "?isnb={$isbn}");
        $responseBody = $response->getBody()->getContents();
        $xml = simplexml_load_string($responseBody, 'SimpleXMLElement', LIBXML_NOCDATA);
        if($xml === false) {
            throw new ISBNApiInvalidResponseException("Invalid XML response from e-isbn.pl API.");
        }

        $xml->registerXPathNamespace("onix", 'http://www.editeur.org/onix/3.0/reference');

        // ISBN
        $isbn = (string) ($xml->xpath('//onix:ProductIdentifier[onix:ProductIDType="15"]/onix:IDValue')[0] ?? '');

        // Title & Subtitle
        $title = (string) ($xml->xpath('//onix:TitleText')[0] ?? '');
        $subtitle = (string) ($xml->xpath('//onix:Subtitle')[0] ?? null);

        // Authors
        $authors = [];
        foreach ($xml->xpath('//onix:Contributor/onix:PersonNameInverted') as $author) {
            $authors[] = (string) $author;
        }

        // Publisher
        $publisher = (string) ($xml->xpath('//onix:PublisherName')[0] ?? '');

        // Publication Date
        $publishedDate = (string) ($xml->xpath('//onix:PublishingDate[onix:PublishingDateRole="09"]/onix:Date')[0] ?? null);

        // Language
        $language = (string) ($xml->xpath('//onix:Language[onix:LanguageRole="01"]/onix:LanguageCode')[0] ?? null);

        // Subjects
        $subjects = [];
        foreach ($xml->xpath('//onix:Subject/onix:SubjectCode') as $subject) {
            $subjects[] = (string) $subject;
        }

        // Edition
        $edition = (string) ($xml->xpath('//onix:EditionNumber')[0] ?? null);

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