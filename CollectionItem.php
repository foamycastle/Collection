<?php

namespace Foamycastle\Collection;

class CollectionItem implements CollectionItemInterface
{
    public readonly string $objectId;
    public function __construct(public readonly int|string $key, public readonly mixed $value=null)
    {
        try{
            $this->objectId = random_bytes(8);
        }catch (\Exception $e){
            $this->objectId = uniqid('', true);
        }
    }

    function withValue(mixed $value = null): CollectionItemInterface
    {
        return new self($this->key, $value ?? $this->value);
    }

    function withKey(int|string $key): CollectionItemInterface
    {
        return new self($key, $this->value);
    }

}