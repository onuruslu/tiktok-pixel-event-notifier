<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos\Properties;

use Onuruslu\TiktokPixelEventNotifier\Dtos\AbstractDto;

class Contents extends AbstractDto
{
    protected ?float $price = null;

    protected ?int $quantity = null;

    protected ?string $contentId = null;

    protected ?string $contentCategory = null;

    protected ?string $contentName = null;

    protected ?string $brand = null;

    public function setPrice(float $price): Contents
    {
        $this->price = $price;

        return $this;
    }

    public function setQuantity(int $quantity): Contents
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setContentId(string $contentId): Contents
    {
        $this->contentId = $contentId;

        return $this;
    }

    public function setContentCategory(string $contentCategory): Contents
    {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    public function setContentName(string $contentName): Contents
    {
        $this->contentName = $contentName;

        return $this;
    }

    public function setBrand(string $brand): Contents
    {
        $this->brand = $brand;

        return $this;
    }

    protected function payload(): array
    {
        return [
            'price' => $this->price,
            'quantity' => $this->quantity,
            'content_id' => $this->contentId,
            'content_category' => $this->contentCategory,
            'content_name' => $this->contentName,
            'brand' => $this->brand,
        ];
    }
}
