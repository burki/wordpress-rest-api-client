<?php

namespace Vnn\WpApiClient\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

/**
 * Class GuzzleAdapter
 * @package Vnn\Infrastructure\Http\Client
 */
class Guzzle5Adapter implements ClientInterface
{
    /**
     * @var Client
     */
    protected $guzzle;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->guzzle = !is_null($client) ? $client : new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function makeUri($uri)
    {
        return new Uri($uri);
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request)
    {
        $response =
            $this->guzzle->send($this->guzzle->createRequest(
                $request->getMethod(), $request->getUri(),
                [ 'headers' => $request->getHeaders() ]));

        return new \GuzzleHttp\Psr7\Response($response->getStatusCode(),
                                             $response->getHeaders(),
                                             $response->getBody(),
                                             $response->getProtocolVersion(),
                                             $response->getReasonPhrase());
    }
}
