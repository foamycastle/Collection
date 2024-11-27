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
    protected iterable $items;

    /**
     * Create a new collection from a list of items
     * @param iterable $items
     * @return CollectionInterface
     */
    static function From(iterable $items):CollectionInterface
    {
        if(is_array($items)) {
            return new Collection(
                array_map(
                    function ($value,$key) {
                        if($value instanceof CollectionItemInterface) {
                            return $value;
                        }
                        return new CollectionItem($key,$value);
                    },
                    array_values($items),
                    array_keys($items)
                )
            );
        }
        if($items instanceof \Traversable) {
            $newCollection = new Collection();
            foreach($items as $key=>$item) {
                $newCollection->items[] = new CollectionItem($key,$item);
            }
            return $newCollection;
        }
        return new Collection([]);
    }

    /**
     * @param CollectionItemInterface[] $items
     * @return CollectionInterface
     */
    static function FromCollectionItems(array $items):CollectionInterface
    {
        return new Collection(
            array_filter(
                $items,
                fn($item) => $item instanceof CollectionItemInterface
            )
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        if($offset instanceof CollectionItem) {
            $offset = $offset->getKey();
        }
        return $this->findByKey($offset)->count() > 0;
    }

    public function offsetGet(mixed $offset): mixed
    {
        if($offset instanceof CollectionItem) {
            return $this->find($offset);
        }
        //return the first item of this collection
        $found=$this->findByKey($offset,true);

        return $found->count() > 0
            ? reset($found->items)->getValue()
            : null;

    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(empty($offset) && $value instanceof CollectionItem) {
            $this->items[] = $value;
            return;
        }
        if($offset instanceof CollectionItem) {
            $found=$this->find($offset);
            if($found!==null) {
                $found->setValue($value);
            }else{
                if($offset->getValue()===null){
                    $offset->setValue($value);
                }
                $this->items[] = $offset;
            }
            return;
        }
        if(is_scalar($offset)) {
            $found=$this->findByKey($offset);
            if($found->count()>0) {
                foreach ($found as $item) {
                    $item->setValue($value);
                }
            }else{
                $this->items[]=new CollectionItem($offset,$value);
            }
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
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
        return
            new Collection(
                array_filter($this->items, $filter),
            );
    }
    public function find(CollectionItemInterface $collectionItem):?CollectionItemInterface
    {
        return
            array_filter(
                $this->items,
                fn($item) => $item->getObjectId() === $collectionItem->getObjectId()
            )[0] ?? null;
    }

    function findByKey(mixed $key, bool $strict=false): CollectionInterface
    {
        return
            self::FromCollectionItems(
                array_filter(
                    $this->items,
                    function(CollectionItemInterface $item) use ($key,$strict) {
                        return $strict
                            ? $item->getKey() === $key
                            : $item->getKey() == $key;
                    }
                )
            );
    }

    function findByKeyType(string $keyType): CollectionInterface
    {
        return
            self::FromCollectionItems(
                array_filter(
                    $this->items,
                    function($item) use ($keyType) {
                        return $item->getKeyType() === $keyType;
                    }
                )
            );
    }

    function findByValue(mixed $value, bool $strict=false): CollectionInterface
    {
        return
            self::FromCollectionItems(
                array_filter(
                    $this->items,
                    function($item) use ($value,$strict) {
                        return $strict
                            ? $item->getValue() === $value
                            : $item->getValue() == $value;
                    }
                )
            );
    }

    function findByValueType(string $valueType): CollectionInterface
    {
        return
            self::FromCollectionItems(
                array_filter(
                    $this->items,
                    function($item) use ($valueType) {
                        return $item->getValueType() === $valueType;
                    }
                )
            );
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