<?php

namespace Foamycastle\Collection\Items;

use Foamycastle\Collection\AbstractItem;

class StringItem extends AbstractItem
{
    public function __construct(string $key,string $value)
    {
        parent::__construct($key, $value);
    }

}