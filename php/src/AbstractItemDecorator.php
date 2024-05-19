<?php

declare(strict_types=1);

namespace GildedRose;

abstract class AbstractItemDecorator
{
    public const int QUALITY_MIN = 0;

    public const int QUALITY_MAX = 50;

    protected Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    abstract public function updateQuality(): void;
}