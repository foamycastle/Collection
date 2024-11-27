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

}
