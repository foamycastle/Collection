<?php

namespace Foamycastle\Collection;

use Foamycastle\Traits\MetaDataObject;
use Foamycastle\Traits\MetaDataObjectInterface;
use SplObjectStorage;

abstract class AbstractCollection implements CollectionInterface
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

    }

}