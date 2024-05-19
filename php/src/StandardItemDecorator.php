<?php

declare(strict_types=1);

namespace GildedRose;

class StandardItemDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        // update quality
        if ($this->item->sellIn <= 0) {
            $this->item->quality -= 2; // spec: once the sellIn date has passed, quality degrades twice as fast
        } else {
            $this->item->quality--; // spec: quality degrades by 1
        }

        // guard minimum quality
        if ($this->item->quality < self::QUALITY_MIN) {
            $this->item->quality = self::QUALITY_MIN; // spec: quality is never negative
        }

        // subtract a day from sellIn
        $this->item->sellIn--; // spec: sellIn decreases by 1
    }
}
