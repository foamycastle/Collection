<?php

namespace Foamycastle\Collection;

use Foamycastle\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function __construct(array $items=[]){
        $this->items = $items;
    }
}