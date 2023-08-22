<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos;

use Onuruslu\TiktokPixelEventNotifier\Dtos\Context\Ad;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Context\Page;
use Onuruslu\TiktokPixelEventNotifier\Dtos\Context\User;

class Context extends AbstractDto
{
    protected ?Ad $ad = null;

    protected ?Page $page = null;

    protected ?User $user = null;

    protected ?string $ip = null;

    protected ?string $userAgent = null;

    public function setAd(Ad $ad): Context
    {
        $this->ad = $ad;

        return $this;
    }

    public function setPage(Page $page): Context
    {
        $this->page = $page;

        return $this;
    }

    public function setUser(User $user): Context
    {
        $this->user = $user;

        return $this;
    }

    public function setIp(string $ip): Context
    {
        $this->ip = $ip;

        return $this;
    }

    public function setUserAgent(string $userAgent): Context
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    protected function payload(): array
    {
        return [
            'ad' => $this->ad?->toArray(),
            'page' => $this->page?->toArray(),
            'user' => $this->user?->toArray(),
            'ip' => $this->ip,
            'user_agent' => $this->userAgent,
        ];
    }
}
