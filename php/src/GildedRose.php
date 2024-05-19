<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const string ITEM_AGED_BRIE = 'Aged Brie';

    private const string ITEM_BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';

    private const string ITEM_SULFURAS = 'Sulfuras, Hand of Ragnaros';

    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        // loop items
        foreach ($this->items as $item) {
            $this->createDecoratorFor($item)->updateQuality();
        }
    }

    private function createDecoratorFor(Item $item): AbstractItemDecorator
    {
        return match ($item->name) {
            self::ITEM_SULFURAS => new LegendaryItemDecorator($item),
            self::ITEM_BACKSTAGE_PASSES => new BackstagePassesDecorator($item),
            self::ITEM_AGED_BRIE => new AgedBrieDecorator($item),
            default => new StandardItemDecorator($item),
        };
    }
}
