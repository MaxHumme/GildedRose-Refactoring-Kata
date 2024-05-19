<?php

declare(strict_types=1);

namespace GildedRose;

class BackstagePassesDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        if ($this->item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
            $this->item->quality++; // spec: aged brie and backstage passes increase in quality the older they get
            if ($this->item->sellIn < 11) {
                if ($this->item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                    $this->item->quality++; // spec backstage passes increase by 2 when sellIn is < 11
                }
            }
            if ($this->item->sellIn < 6) {
                if ($this->item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
                    $this->item->quality++; // spec backstage passes increase by 3 when sellIn is < 6
                }
            }
        }
        if ($this->item->sellIn <= 0) {
            $this->item->quality = self::QUALITY_MIN; // spec: backstage passes are worthless after the concert
        }

        // subtract a day from sellIn
        $this->item->sellIn--;
    }
}
