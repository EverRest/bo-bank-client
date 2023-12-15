<?php
declare(strict_types=1);

namespace App\Services\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

final class HttpClient
{
    /**
     * @var GuzzleClient|null
     */
    protected static ?GuzzleClient $client = null;

    /**
     * Initialize the GuzzleClient.
     *
     * @return void
     */
    public static function initialize(): void
    {
        if (self::$client === null) {
            self::$client = new GuzzleClient();
        }
    }

    /**
     * Perform a GET request using the initialized client.
     *
     * @param string $url
     * @param array $options
     *
     * @return string
     * @throws GuzzleException
     */
    public static function get(string $url, array $options = []): string
    {
        self::initialize();
        $response = self::$client->get($url, $options);

        return $response->getBody()->getContents();
    }
}
