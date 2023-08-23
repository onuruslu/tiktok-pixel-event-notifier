<?php

namespace Onuruslu\TiktokPixelEventNotifier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Event;
use Onuruslu\TiktokPixelEventNotifier\Exceptions\TiktokApiResponseFailException;

class TiktokPixelEventNotifierFacade
{
    public static array $config = [];

    protected const TIKTOK_PIXEL_API_URL = 'https://business-api.tiktok.com/open_api/v1.3/pixel/track/';

    /**
     * @throws GuzzleException
     * @throws TiktokApiResponseFailException
     */
    public static function send(Event $event, string $accessToken): array
    {
        $client = new Client(static::$config);

        $response = $client->post(
            static::TIKTOK_PIXEL_API_URL,
            [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'json' => $event->toArray(),
            ],
        );

        $contents = $response->getBody()->getContents();

        $payload = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        if ( ! isset($payload['code']) || 0 !== $payload['code']) {
            throw new TiktokApiResponseFailException($contents);
        }

        return $payload;
    }
}
