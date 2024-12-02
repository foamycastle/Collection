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
        return !is_null($this->findFirstByKey($offset));
    }

    public function offsetGet(mixed $offset):?CollectionItemInterface
    {
        return $this->findFirstByKey($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) return;
        $item=$this->findFirstByKey($offset);
        if (is_null($item)){
            $newItem=new CollectionItem($offset,$value);
            $this->collection[$newItem->getObjectId()]=$newItem;
        }else{
            $newItem=new CollectionItem($offset,$value);
            unset($this->collection[$item->getObjectId()]);
            $this->collection[$item->getObjectId()]=$newItem;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if (is_null($offset)) return;
        $item=$this->findFirstByKey($offset);
        if (is_null($item)){
            return;
        }
        unset($this->collection[$item->getObjectId()]);
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
    public function findFirstByKey(int|string $key):?CollectionItem
    {
        foreach ($this->collection as $item) {
            if($item->getKey()==$key){
                return $item;
            }
        }
        return null;
    }

    /**
     * Locate a collection item by its value data
     * @param mixed $value the data to locate
     * @return CollectionItem|null
     */
    public function findFirstByValue(mixed $value):?CollectionItemInterface
    {
        foreach ($this->collection as $item) {
            if($item->getValue()===$value){
                return $item;
            }
        }
        return null;
    }

    /**
     * Locate a collection item by its object id
     * @param string $id the id to locate
     * @return CollectionItem|null
     */
    public function findFirstByObjectId(string $id):?CollectionItemInterface
    {
        foreach ($this->collection as $item) {
            if($item->getObjectId()==$id){
                return $item;
            }
        }
        return null;
    }

    function findAnyByKey(int|string $key): array
    {
        return array_filter($this->collection,function($item) use ($key){
            return $item->getKey()==$key;
        });
    }

    function findAnyByValue(int|string $value): array
    {
        return array_filter($this->collection,function($item) use ($value){
            return $item->getValue()===$value;
        });
    }


    public function getKeys():\Generator
    {
        foreach ($this->collection as $item) {
            yield $item->getKey();
        }
    }

    public function getValues():\Generator
    {
        foreach ($this->collection as $item) {
            yield $item->getValue();
        }
    }

    function getKeysWithObjectId(): \Generator
    {
        foreach ($this->collection as $item) {
            yield [$item->getObjectId()=>$item->getKey()];
        }
    }

    function getValuesWithObjectId(): \Generator
    {
        foreach ($this->collection as $item) {
            yield [$item->getObjectId()=>$item->getValue()];
        }
    }



    protected function getNextNumericKey():int
    {
        $keys=[...$this->getKeys()];
        $numericKeys=array_filter($keys,function($key){
            return is_numeric($key);
        });
        rsort($numericKeys);
        return (is_int(reset($numericKeys)) ? current($numericKeys) + 1 : false) ?: 0;
    }

    function add(...$items): void
    {
        $newItems=[];
        $newIndex=$this->getNextNumericKey();
        if(array_is_list($items)) {
            foreach ($items as $item) {
                if ($item instanceof CollectionItem) {
                    $newItems[$item->getObjectId()]=$item;
                    continue;
                }
                if (is_array($item)) {
                    if(array_is_list($item)){
                        foreach ($item as $value) {
                            $newItem=new CollectionItem($newIndex++,$value);
                            $newItems[$newItem->getObjectId()]=$newItem;
                        }
                    }else{
                        foreach ($item as $itemKey=>$itemValue) {
                            $newItem=new CollectionItem($itemKey,$itemValue);
                            $newItems[$newItem->getObjectId()]=$newItem;
                        }
                    }
                    continue;
                }
                if(is_scalar($item)||is_object($item)){
                    $newItem=new CollectionItem($newIndex++,$item);
                    $newItems[$newItem->getObjectId()]=$newItem;
                }
            }
        }else{
            foreach ($items as $itemKey=>$itemValue) {
                $newItem=new CollectionItem($itemKey,$itemValue);
                $newItems[$newItem->getObjectId()]=$newItem;
            }
        }
        $this->collection=array_merge($this->collection,$newItems);
    }

    function remove(int|string $key): void
    {
        $found=$this->findFirstByKey($key);
        if (is_null($found)) return;
        unset($this->collection[$found->getObjectId()]);
    }

    function has(int|string $key): bool
    {
        return $this->findFirstByKey($key)!==null;
    }

}