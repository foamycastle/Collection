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

    public function unserialize(string $data): void
    {
        $unserialize = unserialize($data);
        $this->__unserialize($unserialize);
    }

    public function jsonSerialize(): string|bool
    {
        return json_encode($this->__serialize());
    }

}