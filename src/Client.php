<?php

namespace Optimail\BounceTrap;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class Client
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var Guzzle
     */
    protected $guzzle;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->url = 'https://bouncetrap.com/api/validate-email/';
        $this->guzzle = new Guzzle;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param Guzzle $guzzle
     */
    public function setGuzzle(Guzzle $guzzle): void
    {
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $email
     * @return \Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    public function raw(string $email): ResponseInterface
    {
        try {
            return $this->guzzle->request('GET', urlencode($this->url . $email));
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * @param string $email
     * @param bool $assoc
     * @return stdClass
     * @throws GuzzleException
     * @throws InvalidResponse
     */
    public function json(string $email, bool $assoc = false): stdClass
    {
        $response = $this->raw($email);

        $responseJson = json_decode($response->getBody()->getContents(), $assoc);

        if ($responseJson === null) {
            throw new InvalidResponse('BounceTrap did not provide a valid JSON response.');
        }

        return $responseJson;
    }

    /**
     * @param string $email
     * @return Response
     * @throws GuzzleException
     * @throws InvalidResponse
     */
    public function response(string $email): Response
    {
        $response = $this->json($email);

        return new Response($response);
    }
}