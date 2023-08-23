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

    public function __construct(
        protected string $accessToken,
        protected string $pixelCode,
        protected ?string $testEventCode = null,
    ) {
    }

    public static function init(string $accessToken, string $pixelCode, string $testEventCode = null): static
    {
        return new static($accessToken, $pixelCode, $testEventCode);
    }

    /**
     * @throws GuzzleException
     * @throws TiktokApiResponseFailException
     */
    public function send(Event $event): array
    {
        $client = new Client(static::$config);

        $payload = $event->toArray();

        $payload['pixel_code'] = $this->pixelCode;

        if (! is_null($this->testEventCode)) {
            $payload['test_event_code'] = $this->testEventCode;
        }

        $response = $client->post(
            static::TIKTOK_PIXEL_API_URL,
            [
                'headers' => [
                    'Access-Token' => $this->accessToken,
                ],
                'json' => $payload,
            ],
        );

        $contents = $response->getBody()->getContents();

        $payload = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        if (! isset($payload['code']) || 0 !== $payload['code']) {
            throw new TiktokApiResponseFailException($contents);
        }

        return $payload;
    }
}
