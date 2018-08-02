<?php

namespace Tests;

use Mockery;
use Mockery\MockInterface;
use Optimail\BounceTrap\Client;
use Optimail\BounceTrap\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientTest extends TestCase
{
    public function testClientReturnsRaw(): void
    {
        $data = '{}';

        $client = new Client;
        $client->setGuzzle($this->getClient($data));

        $response = $client->raw('test@test.com')->getBody()->getContents();

        static::assertEquals($data, $response);
    }

    public function testClientReturnsJson(): void
    {
        $data = '{}';

        $client = new Client;
        $client->setGuzzle($this->getClient($data));

        $response = $client->json('test@test.com');

        static::assertEquals($data, json_encode($response));
    }

    public function testClientReturnsResponse(): void
    {
        $data = '{"data":{"value":"test"},"errors":[]}';

        $client = new Client;
        $client->setGuzzle($this->getClient($data));

        $response = $client->response('test@test.com');

        static::assertInstanceOf(Response::class, $response);
    }

    protected function getStreamInterface($data): MockInterface
    {
        $stream = Mockery::mock(StreamInterface::class);

        $stream->shouldReceive('getContents')
            ->andReturn($data);

        return $stream;
    }

    protected function getResponseInterface($data): MockInterface
    {
        $responseMessage = Mockery::mock(ResponseInterface::class);

        $responseMessage->shouldReceive('getBody')
            ->andReturn($this->getStreamInterface($data));

        return $responseMessage;
    }

    public function getClient($data): MockInterface
    {
        $guzzleClient = Mockery::mock(\GuzzleHttp\Client::class);

        $guzzleClient->shouldReceive('request')
            ->andReturn($this->getResponseInterface($data));

        return $guzzleClient;
    }
}