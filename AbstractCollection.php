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
        $outputArray = new static();
        foreach ($this->items as $item) {
            if($filter($item)){
                $outputArray->items[] = $item;
            }
        }
        return $outputArray;
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