<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\AbstractItemDecorator;
use GildedRose\AgedBrieDecorator;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class AgedBrieDecoratorTest extends TestCase
{
    public function testUpdateQuality(): void
    {
        $item = new Item('foo', 10, 5);
        $gildedRose = new AgedBrieDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $item->name);
        $this->assertSame(9, $item->sellIn); // spec: sellIn decreases by 1
        $this->assertSame(6, $item->quality); // spec: quality of aged brie increases the older it gets
    }

    public function testUpdateQualityIncreasesQualityTwiceAsFastWhenSellDateIsPassed(): void
    {
        $item = new Item('foo', 0, 5);
        $gildedRose = new AgedBrieDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(7, $item->quality); // hidden spec: quality of aged brie increases twice as fast when sell date is passed
    }

    public function testUpdateQualityDoesNotIncreaseQualityAboveMaxQuality(): void
    {
        $item = new Item('foo', 10, AbstractItemDecorator::QUALITY_MAX);
        $gildedRose = new AgedBrieDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(AbstractItemDecorator::QUALITY_MAX, $item->quality); // spec: quality can never increase above self::QUALITY_MAX
    }
}
