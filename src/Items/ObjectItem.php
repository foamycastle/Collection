<?php

namespace Foamycastle\Collection\Items;

use Foamycastle\Collection\AbstractItem;

/**
 * @property-read object $value
 * @property-read object $object
 */
class ObjectItem extends AbstractItem
{
    public function __construct(string $key, object $value, array $meta=[])
    {
        parent::__construct($key, $value, $meta);
    }
    public function getClassName():string
    {
        return get_class($this->value);
    }
    public function __get(string $name)
    {
        if ($name == 'value' || $name == 'object') {
            return $this->value;
        }
        return null;
    }

    public function unserialize(string $data)
    {
        // TODO: Implement unserialize() method.
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
    }


}