<?php

declare(strict_types=1);

namespace GildedRose;

class BackstagePassesDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        // update quality
        if ($this->item->sellIn < 1) {
            $this->item->quality = self::QUALITY_MIN; // spec: backstage passes are worthless after the concert
        } elseif ($this->item->sellIn < 6) {
            $this->item->quality += 3; // spec: backstage passes increase by 3 when sellIn is < 6
        } elseif ($this->item->sellIn < 11) {
            $this->item->quality += 2; // spec: backstage passes increase by 2 when sellIn is < 11
        } else {
            $this->item->quality++; // spec: backstage passes increase in quality the older they get
        }

        // guard maximum quality
        if ($this->item->quality > self::QUALITY_MAX) {
            $this->item->quality = self::QUALITY_MAX; // spec: quality can never increase above self::QUALITY_MAX
        }

        // subtract a day from sellIn
        $this->item->sellIn--;
    }
}
