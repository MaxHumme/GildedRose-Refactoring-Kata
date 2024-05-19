<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\LegendaryItemDecorator;
use PHPUnit\Framework\TestCase;

class LegendaryItemDecoratorTest extends TestCase
{
    public function testUpdateQuality(): void
    {
        $item = new Item('foo', 10, 5);
        $gildedRose = new LegendaryItemDecorator($item);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $item->name);
        $this->assertSame(10, $item->sellIn); // spec: sulfuras never has to be sold
        $this->assertSame(5, $item->quality); // spec: sulfuras never degrades in quality
    }
}
