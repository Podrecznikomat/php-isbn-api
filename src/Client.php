<?php

namespace Podrecznikomat\IsbnApi;

use Podrecznikomat\IsbnApi\API\ApiInterface;
use Podrecznikomat\IsbnApi\Exceptions\IsbnApiNotFoundException;
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
     * @throws IsbnApiNotFoundException
     */
    public function __construct(
        string $apiName,
        ...$otherParams
    )
    {
        $this->client = new GuzzleClient();
        $this->api = match ($apiName) {
            IsbnEnum::E_ISBN_PL => new API\EIsbnPL($this->client),
            IsbnEnum::GOOGLE_BOOKS => new API\GoogleBooks($this->client),
            IsbnEnum::OPEN_LIBRARY => new API\OpenLibrary($this->client),
            default => throw new IsbnApiNotFoundException("API with name {$apiName} not found."),
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