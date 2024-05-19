<?php

declare(strict_types=1);

namespace GildedRose;

class AgedBrieDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        if ($this->item->quality < self::QUALITY_MAX) { // spec: quality can never increase above self::QUALITY_MAX
            $this->item->quality++; // spec: quality of aged brie increases the older it gets
        }
        if ($this->item->sellIn <= 0) {
            if ($this->item->quality < self::QUALITY_MAX) {
                $this->item->quality++; // hidden spec: quality of aged brie increases twice as fast when sell date is passed
            }
        }

        // subtract a day from sellIn
        $this->item->sellIn--;
    }
}
