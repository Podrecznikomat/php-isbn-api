<?php

namespace Podrecznikomat\IsbnApi;

use Podrecznikomat\IsbnApi\API\ApiInterface;
use Podrecznikomat\IsbnApi\Exceptions\ISBNApiNotFoundException;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var ApiInterface $api
     */
    protected ApiInterface $api;

    /**
     * @var GuzzleClient $client
     */
    protected GuzzleClient $client;

    /**
     * @param string $apiName
     * @param mixed ...$otherParams For future use if some APIs need e.g. authentication params
     * @throws ISBNApiNotFoundException
     */
    public function __construct(
        string $apiName,
        ...$otherParams
    )
    {
        $this->client = new GuzzleClient();
        $this->api = match ($apiName) {
            IsbnEnum::E_ISBN_PL => new API\EIsbnPL($this->client),
            default => throw new ISBNApiNotFoundException("API with name {$apiName} not found."),
        };
    }

    /**
     * @return ApiInterface
     */
    public function api(): ApiInterface
    {
        return $this->api;
    }
}