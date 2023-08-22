<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos\Context;

use Onuruslu\TiktokPixelEventNotifier\Dtos\AbstractDto;

class Ad extends AbstractDto
{
    protected ?string $callback;

    public function setCallback(string $callback): Ad
    {
        $this->callback = $callback;

        return $this;
    }

    protected function payload(): array
    {
        return [
            'callback' => $this->callback,
        ];
    }
}
