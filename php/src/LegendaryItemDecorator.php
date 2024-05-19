<?php

declare(strict_types=1);

namespace GildedRose;

class LegendaryItemDecorator extends AbstractItemDecorator
{
    public function updateQuality(): void
    {
        // spec: sulfuras never has to be sold and never decreases in quality
        // so no updates done here!
    }
}
