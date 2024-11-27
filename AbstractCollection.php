<?php

namespace Foamycastle\Collection;

use ArrayIterator;
use Traversable;

/**
 * @property-read int $count
 */
abstract class AbstractCollection implements CollectionInterface
{

    /**
     * The list of collection items
     * @var CollectionItem[]
     */
    protected array $collection;

    public function offsetExists(mixed $offset): bool
    {
        return !is_null($this->findByKey($offset));
    }

    public function offsetGet(mixed $offset):?CollectionItemInterface
    {
        return $this->findByKey($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) return;
        $item=$this->findByKey($offset);
        if (is_null($item)){
            $newItem=new CollectionItem($offset,$value);
            $this->collection[$newItem->objectId]=$newItem;
        }else{
            $newItem=new CollectionItem($offset,$value);
            unset($this->collection[$item->objectId]);
            $this->collection[$item->objectId]=$newItem;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if (is_null($offset)) return;
        $item=$this->findByKey($offset);
        if (is_null($item)){
            return;
        }
        unset($this->collection[$item->objectId]);
    }

    public function count(): int
    {
        return count($this->collection);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }


    /**
     * Locate a collection item by its key data
     * @param int|string $key the data to locate
     * @return CollectionItem|null
     */
    protected function findByKey(int|string $key):?CollectionItem
    {
        return
            array_filter(
                $this->collection ?? [],
                function ($item) use ($key) {
                    return $item->key == $key;
                }
            )[0] ?? null;
    }

    /**
     * Locate a collection item by its value data
     * @param mixed $value the data to locate
     * @return CollectionItem|null
     */
    protected function findByValue(mixed $value):?CollectionItem
    {
        return
            array_filter(
                $this->collection ?? [],
                function ($item) use ($value) {
                    return $item->value == $value;
                }
            )[0] ?? null;
    }

    /**
     * Locate a collection item by its object id
     * @param string $id the id to locate
     * @return CollectionItem|null
     */
    protected function findByObjectId(string $id):?CollectionItem
    {
        return
            array_filter(
                $this->collection ?? [],
                function ($item) use ($id) {
                    return $item->objectId == $id;
                }
            )[0] ?? null;
    }

}