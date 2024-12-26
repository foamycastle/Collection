<?php

namespace Foamycastle\Collection;

use Foamycastle\Collection\Items\ArrayItem;
use Foamycastle\Collection\Items\ObjectItem;
use Foamycastle\Collection\Items\StringItem;
use Foamycastle\Traits\MetaDataObject;
use Foamycastle\Traits\MetaDataObjectInterface;
use IteratorAggregate;
use SplObjectStorage;
use Traversable;

abstract class AbstractCollection implements CollectionInterface, IteratorAggregate
{
    protected MetaDataObjectInterface $meta;
    protected SplObjectStorage $collection;

    public function __construct()
    {
        $this->meta = new MetaDataObject();
        $this->collection = new SplObjectStorage();
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
            if($collection instanceof SplObjectStorage) {
                $this->collection->addAll($collection);
                return;
            }
            if(is_array($collection)) {
                $this->appendArray($collection);
                return;
            }
        }
        if(is_array($items)) {
            $this->appendArray($items);
            return;
        }
    }

    function appendArray(array $items): void
    {
        foreach($items as $itemKey => $itemValue) {
            if(is_string($itemKey) || is_int($itemKey)) {
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

    function getItemsByKey(string $key): ?array
    {
        $output=[];
        foreach($this->getIterator() as $item) {
            if($item->getKey() === $key) {
                $output[]=$item;
            }
        }
        return empty($output) ? $output : null;
    }

    public function getAllItems(): Traversable
    {
        return $this->getIterator();
    }

    public function getIterator(): Traversable
    {
        return $this->collection;
    }


}