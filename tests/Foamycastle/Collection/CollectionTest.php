<?php

namespace Foamycastle\Collection;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    public function testFromArray()
    {
        $collection = Collection::fromArray([]);
        $collection['foo'] = 'bar';
    }

    public function testNextNumericKey()
    {
        $collection = Collection::fromArray(['bird'=>1,'faculty'=>2, 3, 4, 5, 'turd']);
        $next=$collection->getNextNumericKey();
        $this->assertEquals(4, $next);
    }

    public function testAdd()
    {
        $newCollection = Collection::fromArray([]);
        $newCollection->add('foo', 'bar');
        $this->assertNotNull($newCollection[0]);
        $this->assertNotNull($newCollection[1]);

        $newCollection = Collection::fromArray([]);
        $newCollection->add(...$_SERVER);
        $this->assertEquals('bar', $newCollection['foo']);
        $this->assertEquals('bleet', $newCollection['parb']);
    }
}
