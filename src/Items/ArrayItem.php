<?php

namespace Foamycastle\Collection\Items;

use ArrayAccess;
use ArrayObject;
use Foamycastle\Collection\AbstractItem;
use Traversable;

class ArrayItem extends AbstractItem implements \IteratorAggregate,ArrayAccess
{
    public function __construct(string $key, array $value, array $meta = [])
    {
        parent::__construct($key, $value, $meta);
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->value[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->value[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->value[$offset]);
    }




    public function unserialize(string $data): void
    {
        $unserialize = unserialize($data);
        $this->__construct(...(new ArrayObject($unserialize)));
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
    }

}