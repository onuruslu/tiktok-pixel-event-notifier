<?php

namespace Onuruslu\TiktokPixelEventNotifier\Dtos\Properties;

use Onuruslu\TiktokPixelEventNotifier\Dtos\AbstractDto;

class Content extends AbstractDto
{
    protected ?float $price = null;

    protected ?int $quantity = null;

    protected ?string $contentId = null;

    protected ?string $contentCategory = null;

    protected ?string $contentName = null;

    protected ?string $brand = null;

    public function setPrice(float $price): Content
    {
        $this->price = $price;

        return $this;
    }

    public function setQuantity(int $quantity): Content
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function setContentId(string $contentId): Content
    {
        $this->contentId = $contentId;

        return $this;
    }

    public function setContentCategory(string $contentCategory): Content
    {
        $this->contentCategory = $contentCategory;

        return $this;
    }

    public function setContentName(string $contentName): Content
    {
        $this->contentName = $contentName;

        return $this;
    }

    public function setBrand(string $brand): Content
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
