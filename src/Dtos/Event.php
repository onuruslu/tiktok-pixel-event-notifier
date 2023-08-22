<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos;

use Onuruslu\TiktokPixelEventNotifier\Enums\EventType;

class Event extends AbstractDto
{
    protected string $pixelCode;

    protected EventType $event;

    protected ?string $eventId = null;

    protected ?string $timestamp = null;

    protected Context $context;

    protected ?Properties $properties = null;

    protected ?string $testEventCode = null;

    public function setPixelCode(string $pixelCode): Event
    {
        $this->pixelCode = $pixelCode;

        return $this;
    }

    public function setEvent(EventType $event): Event
    {
        $this->event = $event;

        return $this;
    }

    public function setEventId(string $eventId): Event
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function setTimestamp(int $unixTimestamp): Event
    {
        $this->timestamp = date('c', $unixTimestamp);

        return $this;
    }

    public function setContext(Context $context): Event
    {
        $this->context = $context;

        return $this;
    }

    public function setProperties(Properties $properties): Event
    {
        $this->properties = $properties;

        return $this;
    }

    public function setTestEventCode(?string $testEventCode): Event
    {
        $this->testEventCode = $testEventCode;
        return $this;
    }

    protected function payload(): array
    {
        return [
            'pixel_code' => $this->pixelCode,
            'event' => $this->event?->value,
            'event_id' => $this->eventId,
            'timestamp' => $this->timestamp,
            'context' => $this->context->toArray(),
            'properties' => $this->properties?->toArray(),
            'test_event_code' => $this->testEventCode,
        ];
    }
}
