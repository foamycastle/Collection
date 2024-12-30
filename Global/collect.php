<?php

use Foamycastle\Collection\CollectionInterface;
use Foamycastle\Collection\Generic\Collection;

function collect($data): CollectionInterface
{
    if($data instanceof CollectionInterface)
        return $data;

    return new Collection($data);

}