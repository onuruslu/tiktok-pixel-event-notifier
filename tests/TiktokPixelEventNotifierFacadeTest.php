<?php

namespace Onuruslu\TiktokPixelEventNotifier\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Context;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Event;
use Onuruslu\TiktokPixelEventNotifier\Enums\EventType;
use Onuruslu\TiktokPixelEventNotifier\Exceptions\TiktokApiResponseFailException;
use Onuruslu\TiktokPixelEventNotifier\TiktokPixelEventNotifierFacade;
use PHPUnit\Framework\TestCase;

class TiktokPixelEventNotifierFacadeTest extends TestCase
{
    public function testSend()
    {
        $pixelCode = 'ABC123***';
        $accessToken = 'ACCESS_TOKEN';

        $event = Event::make()
            ->setEvent(EventType::VIEW_CONTENT)
            ->setContext(
                Context::make()
                    ->setIp('127.0.0.1')
                    ->setUserAgent('Chrome')
            );

        $fakeResponse = '{"code": 0, "message": "OK", "request_id": "202308221528001CE2BBC94574F7569C55", "data": {}}';

        $mock = $this->getMockResponse($fakeResponse);

        $handlerStack = HandlerStack::create($mock);

        $container = [];

        $history = Middleware::history($container);

        $handlerStack->push($history);

        TiktokPixelEventNotifierFacade::$config = ['handler' => $handlerStack];

        $facade = TiktokPixelEventNotifierFacade::init($accessToken, $pixelCode, 'TEST95963');

        $response = $facade->send($event);

        $this->assertEquals(
            json_decode($fakeResponse, true),
            $response
        );

        /** @var Request $request */
        $request = $container[0]['request'];

        $this->assertEquals(
            $request->getHeader('Content-Type'),
            ['application/json']
        );

        $this->assertEquals(
            $request->getHeader('Access-Token'),
            [$accessToken]
        );

        $this->assertEquals(
            $request->getBody()->getContents(),
            '{"event":"ViewContent","context":{"ip":"127.0.0.1","user_agent":"Chrome"},"pixel_code":"' . $pixelCode . '","test_event_code":"TEST95963"}'
        );
    }

    protected function getMockResponse(string $fakeResponse): MockHandler
    {
        $bufferStream = new BufferStream();

        $bufferStream->write($fakeResponse);

        // Create a mock and queue two responses.
        return new MockHandler([
            new Response(200, [], $bufferStream),
        ]);
    }
    public function testSendShouldThrowExceptionWhenApiResponseCodeNotZero()
    {
        $pixelCode = 'ABC123***';
        $accessToken = 'ACCESS_TOKEN';

        $event = Event::make()
            ->setEvent(EventType::VIEW_CONTENT)
            ->setContext(
                Context::make()
                    ->setIp('127.0.0.1')
                    ->setUserAgent('Chrome')
            );

        $fakeResponse = '{"code": -1, "message": "FAIL", "request_id": "202308221528001CE2BBC94574F7569C55", "data": {}}';

        $mock = $this->getMockResponse($fakeResponse);

        $handlerStack = HandlerStack::create($mock);

        TiktokPixelEventNotifierFacade::$config = ['handler' => $handlerStack];

        $this->expectException(TiktokApiResponseFailException::class);

        $this->expectExceptionMessage($fakeResponse);

        $facade = TiktokPixelEventNotifierFacade::init($accessToken, $pixelCode, 'TEST95963');

        $facade->send($event);
    }
}
