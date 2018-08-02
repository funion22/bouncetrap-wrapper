<?php

namespace Tests;

use Optimail\BounceTrap\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testResponseReturnsToArray(): void
    {
        $data = '{"data":[],"errors":[]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        $toArray = $response->toArray();


        static::assertTrue(is_array($toArray));
        static::assertArrayHasKey('data', $toArray);
    }

    public function testResponseHasErrors(): void
    {
        $data = '{"data":[],"errors":["test"]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertTrue($response->hasErrors());
    }

    public function testResponseHasNoErrors(): void
    {
        $data = '{"data":[]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertFalse($response->hasErrors());
    }

    public function testResponseReturnsToJson(): void
    {
        $data = '{"data":[],"errors":[]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals($data, $response->toJson());
    }

    public function testCanGetValueFromResponse(): void
    {
        $data = '{"data":{"value":"test"},"errors":[]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertEquals('test', $response->value);
    }

    public function testIssetReturnsCorrectly(): void
    {
        $data = '{"data":{"value":"test"},"errors":[]}';

        $jsonObj = json_decode($data);

        $response = new Response($jsonObj);

        static::assertTrue(isset($response->value));
        static::assertFalse(isset($response->asd));
    }
}