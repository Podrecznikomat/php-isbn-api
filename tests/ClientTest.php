<?php

namespace Podrecznikomat\tests;

use PHPUnit\Framework\TestCase;
use Podrecznikomat\IsbnApi\API\EIsbnPL;
use Podrecznikomat\IsbnApi\Client;
use Podrecznikomat\IsbnApi\Exceptions\ISBNApiNotFoundException;
use Podrecznikomat\IsbnApi\IsbnEnum;

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
        $this->expectException(ISBNApiNotFoundException::class);
        new Client('INVALID_API_NAME');
    }
}