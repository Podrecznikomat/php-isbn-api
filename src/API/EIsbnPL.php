<?php

namespace Podrecznikomat\IsbnApi\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Podrecznikomat\IsbnApi\Exceptions\IsbnApiInvalidResponseException;
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
     * @throws IsbnApiInvalidResponseException
     */
    public function getBookByIsbn(string $isbn): Book
    {
        $response = $this->client->get($this->baseUrl . "?isbn={$isbn}");
        $responseBody = $response->getBody()->getContents();
        $xml = simplexml_load_string($responseBody, 'SimpleXMLElement', LIBXML_NOCDATA);
        if($xml === false) {
            throw new IsbnApiInvalidResponseException("Invalid XML response from e-isbn.pl API.");
        }

        $xml->registerXPathNamespace("onix", 'http://www.editeur.org/onix/3.0/reference');

        // ISBN
        $isbn = (string) $xml->Product->ProductIdentifier->IDValue;

        // Title & Subtitle
        $title = (string) $xml->Product->DescriptiveDetail->TitleDetail->TitleElement->TitleText;
        $subtitle = (string) ($xml->Product->DescriptiveDetail->TitleDetail->TitleElement->Subtitle ?? null);

        // Authors
        $authors = [];
        foreach ($xml->Product->DescriptiveDetail->Contributor->PersonNameInverted as $author) {
            $authors[] = (string) $author;
        }

        // Publisher
        $publisher = (string) $xml->Product->PublishingDetail->Publisher->PublisherName;

        // Publication Date
        $publishedDate = (string) $xml->Product->PublishingDetail->PublishingDate->Date;

        // Language
        $language = (string) $xml->Product->DescriptiveDetail->Language->LanguageCode;

        // Subjects
        $subjects = [];
        foreach ($xml->Product->DescriptiveDetail->Subject->SubjectCode as $subject) {
            $subjects[] = (string) $subject;
        }

        // Edition
        $edition = (string) $xml->Product->DescriptiveDetail->EditionNumber ?? null;

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