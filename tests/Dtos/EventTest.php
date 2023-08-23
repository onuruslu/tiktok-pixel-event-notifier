<?php

namespace Onuruslu\TiktokPixelEventNotifier\Tests;

use Onuruslu\TiktokPixelEventNotifier\Dtos\Context;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Event;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Properties;
use Onuruslu\TiktokPixelEventNotifier\Enums\ContentType;
use Onuruslu\TiktokPixelEventNotifier\Enums\Currency;
use Onuruslu\TiktokPixelEventNotifier\Enums\EventType;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testToArrayShouldNotReturnNullValues()
    {
        $event = Event::make()
            ->setEvent(EventType::VIEW_CONTENT)
            ->setContext(
                Context::make()
                    ->setIp('127.0.0.1')
                    ->setUserAgent('Chrome')
            );

        $this->assertEquals(
            [
                'event' => 'ViewContent',
                'context' => [
                    'ip' => '127.0.0.1',
                    'user_agent' => 'Chrome',
                ],
            ],
            $event->toArray()
        );
    }

    public function testToArray()
    {
        $event = Event::make()
            ->setEvent(EventType::VIEW_CONTENT)
            ->setEventId('eventId')
            ->setTimestamp(1692712412)
            ->setContext(
                Context::make()
                    ->setAd(
                        Context\Ad::make()->setCallback('callback')
                    )
                    ->setPage(
                        Context\Page::make()
                            ->setUrl('https://www.tiktok.com')
                            ->setReferrer('https://www.google.com')
                    )
                    ->setUser(
                        Context\User::make()
                            ->setExternalId('externalId')
                            ->setEmail('john.doe@tiktok.com')
                            ->setPhoneNumber('+905554443322')
                            ->setTtp('ttp')
                    )
                    ->setIp('127.0.0.1')
                    ->setUserAgent('Chrome')
            )
            ->setProperties(
                Properties::make()
                    ->setContentType(ContentType::PRODUCT)
                    ->setContents(
                        Properties\Contents::make()
                            ->setPrice(20.56)
                            ->setQuantity(1)
                            ->setContentId('contentId')
                            ->setContentCategory('contentCategory')
                            ->setContentName('contentName')
                            ->setBrand('brand')
                    )
                    ->setCurrency(Currency::TRY)
                    ->setValue(123.56)
                    ->setQuery('query')
                    ->setDescription('description')
                    ->setStatus('status')
            );

        $this->assertEquals(
            [
                'event' => 'ViewContent',
                'event_id' => 'eventId',
                'timestamp' => '2023-08-22T13:53:32+00:00',
                'context' => [
                    'ad' => [
                        'callback' => 'callback',
                    ],
                    'page' => [
                        'url' => 'https://www.tiktok.com',
                        'referrer' => 'https://www.google.com',
                    ],
                    'user' => [
                        'external_id' => 'aad28daecf2933caa3d25cae3b7220aa271fd50a30e2dc8b30b18d94be6b2020',
                        'email' => 'caf9b0eda6934976f10d6366eb158c1313965940ea774175a177d8094cba164c',
                        'phone_number' => '93d891ecb6e82af6a73fced2463b292ffa5c9b2004299ff2e912904a012fb3e7',
                        'ttp' => 'ttp',
                    ],
                    'ip' => '127.0.0.1',
                    'user_agent' => 'Chrome',
                ],
                'properties' => [
                    'content_type' => 'product',
                    'contents' => [
                        'price' => 20.56,
                        'quantity' => 1,
                        'content_id' => 'contentId',
                        'content_category' => 'contentCategory',
                        'content_name' => 'contentName',
                        'brand' => 'brand',
                    ],
                    'currency' => 'TRY',
                    'value' => 123.56,
                    'query' => 'query',
                    'description' => 'description',
                    'status' => 'status',
                ],
            ],
            $event->toArray()
        );
    }
}
