<?php

namespace Foamycastle\CollectionTest;

use PHPUnit\Framework\TestCase;
use Foamycastle\Collection\Collection;
class CollectionTest extends TestCase
{
    public function testFindAll(){
        $collection = new Collection();
        $collection->append(['foo' => 'bar', 'baz' => 'qux', 'quuz' => 'quuz', 'quuz2' => 'quuz', 'quuz3' => 'quuz']);

        $found = $collection->findAll(key:'foo',value:'quuz');
        $this->assertArrayHasKey('foo', $found);
        $this->assertArrayHasKey('quuz', $found);

        $found=$collection->findAll(['foo','baz'],['quuz']);

    }
    public function testFind()
    {
        $collection = new Collection();
        $collection->append(['dork'=>'nerd']);
        $collection->append('turd','bucket');
        $collection->append(key: 'muscles',value: 'skeleton');
        $collection->append(key: 'fork',value: 'spoon');
        $collection->append(key: 'table',value: 'cloth');
        $collection->append(key: 'kitchen',value: 'counter');

        $this->assertNotNull($collection->findFirst(['dork'=>'nerd']));
        $this->assertNotNull($collection->findFirst(key: 'table'));
        $this->assertNotNull($collection->findFirst(turd: 'bucket'));
        $this->assertEquals('spoon', $collection->findFirst(key: 'fork'));
    }

}
