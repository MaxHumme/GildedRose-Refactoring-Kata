<?php

declare(strict_types=1);

namespace GildedRose;

class StandardItemDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        // handle quality when sell date is not passed
        if ($this->item->quality > self::QUALITY_MIN) { // spec: quality is never negative
            $this->item->quality--;
        }

        // handle 'passed sell date' quality rules
        if ($this->item->sellIn <= 0) {
            if ($this->item->quality > self::QUALITY_MIN) { // spec: quality is never negative
                $this->item->quality--; // spec: once the sellIn date has passed, quality degrades twice as fast
            }
        }

        // subtract a day from sellIn
        $this->item->sellIn--;
    }
}
