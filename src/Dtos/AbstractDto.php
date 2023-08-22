<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos;

abstract class AbstractDto
{
    abstract protected function payload(): array;

    public static function make(): static
    {
        return new static();
    }

    protected static function discardNullValuesFilter(): callable
    {
        return fn (mixed $value) => ! is_null($value);
    }

    public function toArray(): ?array
    {
        $filter = static::discardNullValuesFilter();

        $payload = array_filter($this->payload(), $filter);

        if (0 >= count($payload)) {
            return null;
        }

        return $payload;
    }
}
