<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    const int QUALITY_MIN = 0;
    const int QUALITY_MAX = 50;

    /**
     * @param Item[] $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    public function updateQuality(): void
    {
        // loop items
        foreach ($this->items as $item) {
            if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                continue; // spec: sulfuras never has to be sold and never decreases in quality
            }

            if ($item->name === 'Aged Brie') {
                if ($item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                    $item->quality++; // spec: aged brie and backstage passes increase in quality the older they get
                }
                if ($item->sellIn <= 0) {
                    if ($item->quality < self::QUALITY_MAX) {
                        $item->quality++; // spec: quality of aged brie increases the older it gets
                    }
                }
            } elseif ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                    $item->quality++; // spec: aged brie and backstage passes increase in quality the older they get
                    if ($item->sellIn < 11) {
                        if ($item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                            $item->quality++; // spec backstage passes increase by 2 when sellIn is < 11
                        }
                    }
                    if ($item->sellIn < 6) {
                        if ($item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                            $item->quality++; // spec backstage passes increase by 3 when sellIn is < 6
                        }
                    }
                }
                if ($item->sellIn <= 0) {
                    $item->quality = self::QUALITY_MIN; // spec: backstage passes are worthless after the concert
                }
            } else {
                // handle quality when sell date is not passed
                if ($item->quality > self::QUALITY_MIN) { // spec: quality is never negative
                    $item->quality--;
                }

                // handle 'passed sell date' quality rules
                if ($item->sellIn <= 0) {
                    if ($item->quality > self::QUALITY_MIN) { // spec: quality is never negative
                        $item->quality--; // spec: once the sellIn date has passed, quality degrades twice as fast
                    }
                }
            }

            // subtract a day from sellIn
            $item->sellIn--;
        }
    }
}
