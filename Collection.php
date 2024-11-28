<?php

namespace Foamycastle\Collection;

class Collection extends AbstractCollection
{
    protected function __construct()
    {
        $this->collection=[];
    }
    public static function FromArray(array $collection):static
    {
        $newCollection = new static();
        foreach ($collection as $key=>$value) {
            $newItem=new CollectionItem($key,$value);
            $newCollection->collection[$newItem->getObjectId()]=$newItem;
        }
        return $newCollection;
    }

}