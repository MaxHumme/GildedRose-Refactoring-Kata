<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
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

            // handle quality when sell date is not passed
            if ($item->name === 'Aged Brie' || $item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality < 50) { // spec: quality can never increase above 50
                    $item->quality++; // spec: aged brie and backstage passes increase in quality the older they get
                    if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sellIn < 11) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1; // spec backstage passes increase by 2 when sellIn is < 11
                            }
                        }
                        if ($item->sellIn < 6) {
                            if ($item->quality < 50) {
                                $item->quality = $item->quality + 1; // spec backstage passes increase by 2 when sellIn is < 6
                            }
                        }
                    }
                }
            } elseif ($item->quality > 0) { // spec: quality is never negative
                $item->quality--;
            }

            // subtract a day from sellIn
            $item->sellIn--;

            // handle 'passed sell date' quality rules
            if ($item->sellIn < 0) {
                if ($item->name === 'Aged Brie') {
                    if ($item->quality < 50) {
                        $item->quality++; // spec: quality of aged brie increases the older it gets
                    }
                } elseif ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                    $item->quality = 0; // spec: backstage passes are worthless after the concert
                } elseif ($item->quality > 0) { // spec: quality is never negative
                    $item->quality--; // spec: once the sellIn date has passed, quality degrades twice as fast
                }
            }
        }
    }
}
