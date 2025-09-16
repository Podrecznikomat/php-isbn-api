<?php

namespace Podrecznikomat\IsbnApi\Object;

class Book
{
    public string $isbn;
    public string $title;
    public ?string $subtitle;
    public array $authors = [];
    public string $publisher;
    public ?string $publishedDate;
    public ?string $language;
    public array $subjects;
    public ?string $edition;

    /**
     * @param string $isbn
     * @param string $title
     * @param string|null $subtitle
     * @param array $authors
     * @param string $publisher
     * @param string|null $publishedDate
     * @param string|null $language
     * @param array $subjects
     * @param string|null $edition
     */
    public function __construct(
        string $isbn,
        string $title,
        ?string $subtitle = null,
        array $authors = [],
        string $publisher = '',
        ?string $publishedDate = null,
        ?string $language = null,
        array $subjects = [],
        ?string $edition = null
    ) {
        $this->isbn = $isbn;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->authors = $authors;
        $this->publisher = $publisher;
        $this->publishedDate = $publishedDate;
        $this->language = $language;
        $this->subjects = $subjects;
        $this->edition = $edition;
    }

    /**
     * @return string
     */
    public function getFullTitle(): string
    {
        return $this->subtitle
            ? "{$this->title}: {$this->subtitle}"
            : $this->title;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getAuthorsAsString(string $separator = ', '): string
    {
        return implode($separator, $this->authors);
    }
}