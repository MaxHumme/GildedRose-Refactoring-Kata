<?php

declare(strict_types=1);

namespace GildedRose;

class AgedBrieDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        // update quality
        if ($this->item->sellIn <= 0) {
            $this->item->quality += 2; // hidden spec: quality of aged brie increases twice as fast when sell date is passed
        } else {
            $this->item->quality++; // spec: quality of aged brie increases the older it gets
        }

        // guard maximum quality
        if ($this->item->quality > self::QUALITY_MAX) {
            $this->item->quality = self::QUALITY_MAX; // spec: quality can never increase above self::QUALITY_MAX
        }

        // subtract a day from sellIn
        $this->item->sellIn--;
    }
}
