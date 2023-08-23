<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos;

use Onuruslu\TiktokPixelEventNotifier\Dtos\Properties\Content;
use Onuruslu\TiktokPixelEventNotifier\Enums\ContentType;
use Onuruslu\TiktokPixelEventNotifier\Enums\Currency;

class Properties extends AbstractDto
{
    protected ?ContentType $contentType = null;

    /** @var array<Content> $contents */
    protected array $contents = [];

    protected ?Currency $currency = null;

    protected ?float $value = null;

    protected ?string $query = null;

    protected ?string $description = null;

    protected ?string $status = null;

    public function setContentType(ContentType $contentType): Properties
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function addContent(Content $content): Properties
    {
        $this->contents[] = $content;

        return $this;
    }

    public function setCurrency(Currency $currency): Properties
    {
        $this->currency = $currency;

        return $this;
    }

    public function setValue(float $value): Properties
    {
        $this->value = $value;

        return $this;
    }

    public function setQuery(string $query): Properties
    {
        $this->query = $query;

        return $this;
    }

    public function setDescription(string $description): Properties
    {
        $this->description = $description;

        return $this;
    }

    public function setStatus(string $status): Properties
    {
        $this->status = $status;

        return $this;
    }

    protected function payload(): array
    {
        $contents = [];

        foreach ($this->contents as $content) {
            $contents[] = $content->toArray();
        }

        if (0 >= count($contents)) {
            $contents = null;
        }

        return [
            'content_type' => $this->contentType?->value,
            'contents' => $contents,
            'currency' => $this->currency?->value,
            'value' => $this->value,
            'query' => $this->query,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
