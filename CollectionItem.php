<?php

namespace Foamycastle\Collection;

class CollectionItem implements CollectionItemInterface
{
    private string $objectId;
    public function __construct(private mixed $key, private mixed $value=null)
    {
        $this->objectId = uniqid(random_bytes(4),true);
    }

    function getKey(): mixed
    {
        return $this->key;
    }

    function getValue(): mixed
    {
        return $this->value;
    }

    function setKey(mixed $key): CollectionItemInterface
    {
        $this->key = $key;
        return $this;
    }

    function setValue(mixed $value): CollectionItemInterface
    {
        $this->value = $value;
        return $this;
    }

    function getKeyType(): string
    {
        if(is_object($this->key)) {
            return get_class($this->key);
        }
        return gettype($this->key);
    }

    function getValueType(): string
    {
        if(is_object($this->key)) {
            return get_class($this->value);
        }
        return gettype($this->value);
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function tuple(): array
    {
        return [$this->key,$this->value];
    }

    public function __toString(): string
    {
        if(is_scalar($this->value)) {
            if(is_bool($this->value)) {
                return $this->value ? 'true' : 'false';
            }
            return (string)$this->value;
        }
        return (new Stringify($this->value));
    }
}