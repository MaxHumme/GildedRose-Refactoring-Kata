<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\AbstractItemDecorator;
use GildedRose\ConjuredItemDecorator;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class ConjuredItemDecoratorTest extends TestCase
{
    public function testUpdateQuality(): void
    {
        $item = new Item('foo', 10, 5);
        $gildedRose = new ConjuredItemDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $item->name);
        $this->assertSame(9, $item->sellIn); // spec: sellIn decreases by 1
        $this->assertSame(3, $item->quality); // spec: quality degrades by 2
    }

    public function testUpdateQualityDegradesQualityTwiceAsFastWhenSellDateIsPassed(): void
    {
        $item = new Item('foo', 0, 5);
        $gildedRose = new ConjuredItemDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(1, $item->quality); // spec: quality degrades twice as fast when sell date is passed
    }

    public function testUpdateQualityDoesNotDecreaseQualityBelowMinimumQuality(): void
    {
        $item = new Item('foo', 10, 0);
        $gildedRose = new ConjuredItemDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(AbstractItemDecorator::QUALITY_MIN, $item->quality); // spec: quality is never below minimum quality
    }
}