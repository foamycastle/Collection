<?php

namespace Foamycastle\Collection;

/**
 * @property-read int $count
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * An array of containers that store key-value pairs
     * @var list<CollectionItemInterface>
     */
    protected array $items;

    /**
     * Create a collection from separate key and value arrays
     * @param list<mixed> $keys
     * @param list<mixed> $data
     * @return CollectionInterface
     */
    static function New():CollectionInterface
    {
        return new static();
    }
    static function From(array $keys, ?array $data = null): CollectionInterface
    {
        $newCollection = new static();
        if (array_is_list($keys) && array_is_list($data)) {
            $newCollection->items =
                array_map(function ($key, $datum) {
                    return new CollectionItem($key, $datum);
                },
                    $keys, $data);
            return $newCollection;
        }
        if ($data === null) {
            if (array_is_list($keys)) {
                $newCollection->items =
                    array_map(function ($key) {
                        return new CollectionItem($key, null);
                    }, $keys);
                return $newCollection;
            }
            $newCollection->items = array_map(function ($key,$value) {
                return new CollectionItem($key, $value);
            },array_keys($keys),array_values($keys));
            return $newCollection;
        }
        do {
            $newCollection->items[] = new CollectionItem(current($keys), current($data));
        } while (next($data) && next($keys));
        return $newCollection;
    }

    function append(mixed $key, mixed $value): CollectionInterface
    {
        $this->items[] = new CollectionItem($key, $value);
        return $this;
    }

    function prepend(mixed $key, mixed $value): CollectionInterface
    {
        array_unshift($this->items, new CollectionItem($key, $value));
        return $this;
    }

    public function pop(): CollectionItemInterface
    {
        return array_pop($this->items);
    }

    public function shift(): CollectionItemInterface
    {
        return array_shift($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        if (is_int($offset)) {
            return isset($this->items[$offset]);
        }
        return !empty(
        array_filter($this->items, function ($item) use ($offset) {
            return $item->getKey() === $offset;
        })
        );
    }

    /**
     * Returns a collection of matching keys
     * @param mixed $offset
     * @return CollectionInterface
     */
    public function offsetGet(mixed $offset): mixed
    {
        if(is_string($offset)) {
            if($this->hasKey($offset)){
                return $this->findKeysWhere($offset)->first()->getValue();
            }
        }
        return $this->findKeysWhere($offset);
    }

    /**
     * Reduces the collection to a list of items that match based on the given criteria
     * @param mixed $key Items are matched primarily on this value. Comparison is strict.
     * @param mixed|null $data If provided, both `$key` and this value must match.  As with `$key`, comparison is also strict.
     * @return CollectionInterface
     */
    public function findKeysWhere(mixed $key, mixed $data = null): self
    {
        return self::FromCollectionItems(
            array_filter(
                $this->items,
                function ($item) use ($key, $data) {
                    return $data !== null
                        ? ($key === $item->getKey() && $data === $item->getValue())
                        : $key === $item->getKey();
                }
            )
        );
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        foreach ($this->items as $item) {
            if ($item->getKey() === $offset) {
                $item->setValue($value);
            }
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->items = array_filter($this->items, function ($item) use ($offset) {
            return !$item->getKey() === $offset;
        });
    }

    public function current(): CollectionItemInterface
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function key(): int
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    function setDataWhereKey(mixed $whereKey, mixed $value, bool $strict = false): CollectionInterface
    {
        foreach ($this->items as $item) {
            if ($strict ? $item->getKey() === $whereKey : $item->getKey() == $whereKey) {
                $item->setValue($value);
            }
        }
        return $this;
    }

    function setKeyWhereData(mixed $key, mixed $whereValue, bool $strict = false): CollectionInterface
    {
        foreach ($this->items as $item) {
            if ($strict ? $item->getValue() === $whereValue : $item->getValue() == $whereValue) {
                $item->setKey($key);
            }
        }
        return $this;
    }

    function first(): CollectionItemInterface
    {
        return reset($this->items);
    }

    function last(): CollectionItemInterface
    {
        return end($this->items);
    }
    public function hasKey(mixed $key): bool
    {
        return !empty(
            array_filter(
                $this->items,
                function ($item) use ($key) {
                    return $item->getKey() === $key;
                }
            )
        );
    }

    /**
     * Reduced the collection to a list of items based on the given criteria
     * @param mixed $data Items are matched primarily on this value. Comparison is strict.
     * @param mixed|null $key If provided, both `$data` and this value must match.  As with `$data`, comparison is also strict.
     * @return CollectionInterface
     */
    public function findDataWhere(mixed $data, mixed $key = null): self
    {
        return self::FromCollectionItems(
            array_filter(
                $this->items,
                function ($item) use ($key, $data) {
                    return $key !== null
                        ? ($data === $item->getValue() && $key === $item->getKey())
                        : $data === $item->getValue();
                }
            )
        );
    }

    /**
     * Create a collection from an established list of collection items.  Used exclusively for mutation.
     * @param CollectionItemInterface[] $items
     * @return CollectionInterface
     */
    protected static function FromCollectionItems(array $items): CollectionInterface
    {
        $newCollection = new static();
        $newCollection->items = $items;
        return $newCollection;
    }


}