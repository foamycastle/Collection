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

    /**
     * Add an associative array or an array of `ItemInterface`
     * @param array $items
     * @return void
     */
    function appendArray(array $items):void;

    /**
     * Add the items from an existing collection or an array
     * @param $items
     * @return void
     */
    function appendAll($items):void;

    /**
     * Retrieve an item referenced by the key
     * @param string $key
     * @return ItemInterface|null
     */
    function getItemByKey(string $key):?ItemInterface;

    /**
     *
     * @param string $key
     * @return array|null
     */
    function getItemsByKey(string $key):\Traversable;
    function getAllItems():mixed;

    /**
     * Return the collection type
     * @return string
     */
    function getCollectionType():string;

}