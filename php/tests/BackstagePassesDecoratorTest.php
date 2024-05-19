<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\AbstractItemDecorator;
use GildedRose\BackstagePassesDecorator;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class BackstagePassesDecoratorTest extends TestCase
{
    public function testUpdateQuality(): void
    {
        $item = new Item('foo', 20, 5);
        $gildedRose = new BackstagePassesDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $item->name);
        $this->assertSame(19, $item->sellIn); // spec: sellIn decreases by 1
        $this->assertSame(6, $item->quality); // spec: quality of backstage passes increases the older they get
    }

    public function testUpdateQualityIncreasesQualityBy2When10DaysOrLess(): void
    {
        $item = new Item('foo', 10, 5);
        $gildedRose = new BackstagePassesDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(7, $item->quality); // spec: backstage passes increase by 2 when sellIn is < 11
    }

    public function testUpdateQualityIncreasesQualityBy3When5DaysOrLess(): void
    {
        $item = new Item('foo', 5, 5);
        $gildedRose = new BackstagePassesDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(8, $item->quality); // spec: backstage passes increase by 3 when sellIn is < 6
    }

    public function testUpdateQualityDoesNotIncreaseQualityAboveMaxQuality(): void
    {
        $item = new Item('foo', 10, AbstractItemDecorator::QUALITY_MAX);
        $gildedRose = new BackstagePassesDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(AbstractItemDecorator::QUALITY_MAX, $item->quality); // spec: quality can never increase above self::QUALITY_MAX
    }

    public function testUpdateQualitySetsQualityToMinimumWhenSellDateIsPassed(): void
    {
        $item = new Item('foo', 0, 10);
        $gildedRose = new BackstagePassesDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame(AbstractItemDecorator::QUALITY_MIN, $item->quality); // spec: backstage passes are worthless after the concert
    }
}
