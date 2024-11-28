<?php

namespace Foamycastle\Collection;

class CollectionItem implements CollectionItemInterface
{
    protected string $objectId;
    public function __construct(protected int|string $key, protected mixed $value=null)
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

    function getKey(): string|int
    {
        return $this->key ?? "";
    }

    function getValue(): mixed
    {
        return $this->value ?? "";
    }

    function getObjectId(): string
    {
        return $this->objectId ?? "";
    }


}