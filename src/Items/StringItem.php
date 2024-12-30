<?php

namespace Foamycastle\Collection\Items;

use Foamycastle\Collection\AbstractItem;

/**
 * @property-read string $string
 */
class StringItem extends AbstractItem
{
    public function __construct(string $key,string $value, array $meta=[])
    {
        parent::__construct($key, $value, $meta);
    }
    public function __set(string $name, $value): void
    {
        if ($name == 'string') {
            $this->value = $value;
        }
    }
    public function __get(string $name): mixed
    {
        if ($name == 'string') {
            return $this->value;
        }
        return null;
    }

    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    public function unserialize(string $data)
    {
        // TODO: Implement unserialize() method.
    }

    public function jsonSerialize(): mixed
    {
        return json_encode($this->__serialize());
    }

}