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
     * Create a new collection from a list of items
     * @param array $items
     * @return CollectionInterface
     */
    static function FromList(array $items):CollectionInterface
    {
        $counter=0;
        return new Collection(
            array_map(
                function ($value) use (&$counter) {
                    return new CollectionItem($counter++,$value);
                },
                array_values($items)
            )
        );

    }

    /**
     * Create a collection from a list of keys and values. If the number of elements in the `$keys`
     * array does not match the number of elements in the `$values` array, a list collection is returned
     * comprised of only values
     * @param array $keys
     * @param array $values
     * @return CollectionInterface
     */
    static function FromKeysAndValues(array $keys,array $values):CollectionInterface
    {
        if(count($keys)!=count($values)) {
            return static::FromList($values);
        }
        return new Collection(
            array_map(
                function ($key,$value) {
                    return new CollectionItem($key,$value);
                },
                $keys,$values
            )
        );
    }

    static function FromCollectionItems(array $items):CollectionInterface
    {
        $newCollection = new static();
        $newCollection->items = $items;
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

    function filter(callable $filter):CollectionInterface
    {

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


}