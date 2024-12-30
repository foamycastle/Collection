<?php

namespace Foamycastle\Collection;

use Foamycastle\Collection\Items\ArrayItem;
use Foamycastle\Collection\Items\ObjectItem;
use Foamycastle\Collection\Items\StringItem;
use Foamycastle\Traits\MetaDataObject;
use Foamycastle\Traits\MetaDataObjectInterface;
use IteratorAggregate;
use MongoDB\BSON\Iterator;
use SplObjectStorage;
use Traversable;

abstract class AbstractCollection implements CollectionInterface, IteratorAggregate, \ArrayAccess
{
    protected MetaDataObjectInterface $meta;
    protected SplObjectStorage $collection;

    public function __construct()
    {
        $this->meta = new MetaDataObject();
        $this->collection = new SplObjectStorage();
    }

    protected function setCollectionType(string $type):void
    {
        $this->meta->add('type', $type);
    }

    function getCollectionType(): string
    {
        return $this->meta->has('type') ? $this->meta->get('type') : '';
    }


    protected function setMetaData(MetaDataKeys $key, mixed $value):void
    {
        $this->meta[$key] = $value;
    }
    protected function getMetaData(MetaDataKeys $key):mixed
    {
        return $this->meta[$key];
    }

    function append(string $key, mixed $data, array $meta = []): void
    {
        $newObject = match(gettype($data)) {
            'string' => new StringItem($key, $data),
            'object' => new ObjectItem($key, $data),
            'array'  => new ArrayItem($key, $data),
        };
        $this->collection->attach($newObject, $meta);
    }

    function appendItem(ItemInterface $item): void
    {
        if($this->collection->contains($item)) return;
        $this->collection->attach($item);
    }

    function appendAll($items): void
    {
        if($items instanceof AbstractCollection) {
            $collection = $items->getAllItems();
            $this->appendArray($collection);
            return;
        }
        if(is_array($items)) {
            $this->appendArray($items);
        }
    }

    function appendArray(array $items): void
    {
        foreach($items as $itemKey => $itemValue) {
            if(is_string($itemKey) || is_int($itemKey)) {
                if($itemValue instanceof ItemInterface) {
                    $this->appendItem($itemValue);
                    continue;
                }
                $this->append($itemKey, $itemValue);
            }
        }
    }

    public function getItemByKey(string $key): ?ItemInterface
    {
        foreach($this->getIterator() as $item) {
            if($item->getKey() === $key) {
                return $item;
            }
        }
        return null;
    }

    function getItemsByKey(string $key): \Traversable
    {
        foreach($this->getIterator() as $item) {
            if($item->getKey() === $key) {
                yield $item;
            }
        }
    }

    public function getAllItems(): array
    {
        return [...$this->getIterator()];
    }

    public function getIterator(): Traversable
    {
        $this->collection->rewind();
        while($this->collection->valid()) {
            yield $this->collection->current();
            $this->collection->next();
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        foreach($this->getIterator() as $item) {
            if($item->getKey() === $offset) {
                return true;
            }
        }
        return false;
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getItemByKey($offset)?->getValue();
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->getItemByKey($offset)?->withValue($value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $item=$this->getItemByKey($offset);
        if($item instanceof ItemInterface) {
            $this->collection->offsetUnset($item);
        }
    }


}