<?php

namespace Foamycastle\Collection;

use Generator;
use PhpParser\Node\Expr\Closure;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{

    public function testFromList()
    {
        $collection=Collection::From([1, 2, 3]);
        $this->assertEquals(3, $collection->count());

        $collection=Collection::From(['turd','murd','luird']);
        $this->assertEquals('turd', $collection[0]);
        $this->assertEquals('murd', $collection[1]);
        $this->assertEquals('luird', $collection[2]);

        $collection=Collection::From(
            [
                'tower'=>'power',
                'pork'=>'bahn mi',
                'bowler'=>'shoes'
            ]
        );
        $this->assertEquals('power', $collection['tower']);

        $collection=Collection::From(
            [
                new CollectionItem('high value','forty 11'),
                new CollectionItem('massive 7','7 sevens'),
                new CollectionItem('terrible 2','gangly 10'),
            ]
        );
        $this->assertEquals('forty 11', $collection['high value']);
    }

    public function testFindByValueType()
    {
        $collection=Collection::From(
            [
                new CollectionItem(true,'class-string-object'),
                new CollectionItem(true,'resource-string-object'),
                new CollectionItem(50,['this','is','an','array']),
            ]
        );
        $this->assertIsArray((array)$collection->findByValueType('string'));
        $this->assertEquals(2,$collection->findByValueType('string')->count());
    }

    public function testOffsetGet()
    {
        $collection=Collection::From(
            [
                'tower'=>'power',
                'pork'=>'bahn mi',
                'bowler'=>'shoes'
            ]
        );
        $collection['fucked up']=900;
        $collection[(new CollectionItem('tird','bath'))]=null;
        $this->assertEquals(900, $collection['fucked up']);
        $this->assertEquals('bath', $collection['tird']);
    }

    public function testFromCollectionItems()
    {

    }

    public function testOffsetUnset()
    {

    }

    public function testOffsetSet()
    {

    }

    public function testOffsetExists()
    {

    }

    public function testFindByKey()
    {

    }

    public function testFindByValue()
    {

    }

    public function testFilter()
    {

    }

    public function testFind()
    {
        return '900';
    }

    public function testFromKeysAndValues()
    {

    }

    public function testFindByKeyType()
    {

    }

}
