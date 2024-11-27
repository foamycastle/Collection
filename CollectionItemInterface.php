<?php

namespace Foamycastle\Collection;

interface CollectionItemInterface
{
    function withValue(mixed $value=null):CollectionItemInterface;
    function withKey(int|string $key):CollectionItemInterface;
}