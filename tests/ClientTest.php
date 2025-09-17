<?php

namespace Podrecznikomat\IsbnApi\Tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\API\EIsbnPL;
use Podrecznikomat\IsbnApi\Client;
use Podrecznikomat\IsbnApi\Exceptions\IsbnApiNotFoundException;
use Podrecznikomat\IsbnApi\IsbnEnum;
use Podrecznikomat\IsbnApi\Object\Book;

final class ClientTest extends TestCase
{
    public function testInitClient(): void
    {
        $client = new Client(IsbnEnum::E_ISBN_PL);
        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(EIsbnPL::class, $client->api());
    }

    public function testInvalidClient(): void
    {
        $this->expectException(IsbnApiNotFoundException::class);
        new Client('INVALID_API_NAME');
    }

    public function testGoogleBooks(): void
    {
        $client = new Client(IsbnEnum::GOOGLE_BOOKS);
        $isbn = "9783161484100";
        $title = "Kisiwa cha giza";

        $response = $client->api()->getBookByIsbn($isbn);
        $this->assertInstanceOf(Book::class, $response);
        $this->assertEquals($title, $response->title);
        $this->assertEquals($isbn, $response->isbn);
    }

    public function testEIsbnPL(): void
    {
        $client = new Client(IsbnEnum::E_ISBN_PL);
        $isbn = "9788394063610";
        $title = "Słownik historyczny Nowej Marchii w  sredniowieczu";

        $response = $client->api()->getBookByIsbn($isbn);
        $this->assertInstanceOf(Book::class, $response);
        $this->assertEquals($title, $response->title);
        $this->assertEquals($isbn, $response->isbn);
    }

    public function testOpenLibrary(): void
    {
        $client = new Client(IsbnEnum::OPEN_LIBRARY);
        $isbn = "9783161484100";
        $title = "Deadliest big cats";

        $response = $client->api()->getBookByIsbn($isbn);
        $this->assertInstanceOf(Book::class, $response);
        $this->assertEquals($title, $response->title);
        $this->assertEquals($isbn, $response->isbn);
    }
}