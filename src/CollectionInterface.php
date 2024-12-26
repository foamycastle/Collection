<?php

namespace Foamycastle\Collection;

interface CollectionInterface
{

    /**
     * Add an item to the collection
     * @param string $key the identifier by which the user references the item
     * @param mixed $data the data to add to the collection
     * @param array<array-key<string>,string|int|array> $meta optional metadata to add to the collection
     * @return void
     */
    function append(string $key, mixed $data, array $meta=[]):void;

    /**
     * Add an item object to the collection
     * @param ItemInterface $item The item object
     * @return void
     */
    function appendItem(ItemInterface $item):void;

    function appendArray(array $items):void;

    function appendAll($items):void;
    function getItemByKey(string $key):?ItemInterface;
    function getItemsByKey(string $key):?array;
    function getAllItems():mixed;

}