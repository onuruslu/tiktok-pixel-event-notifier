<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos\Context;

use Onuruslu\TiktokPixelEventNotifier\Dtos\AbstractDto;

class Page extends AbstractDto
{
    protected ?string $url = null;

    protected ?string $referrer = null;

    public function setUrl(string $url): Page
    {
        $this->url = $url;

        return $this;
    }

    public function setReferrer(string $referrer): Page
    {
        $this->referrer = $referrer;

        return $this;
    }

    protected function payload(): array
    {
        return [
            'url' => $this->url,
            'referrer' => $this->referrer,
        ];
    }
}
