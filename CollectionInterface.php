<?php

namespace Foamycastle\Collection;

interface CollectionInterface extends \Iterator, \Countable, \ArrayAccess
{

    /**
     * Append a value to the collection
     * @param mixed $value
     * @param mixed $key
     * @return  self
     */
    function append(mixed $key,mixed $value): self;

    /**
     * Add a value to the beginning of the collection
     * @param mixed $key
     * @param mixed $value
     * @return self
     */
    function prepend(mixed $key, mixed $value): self;

    /**
     * Remove and return the first value in the collection
     * @return CollectionItemInterface
     */
    function shift(): CollectionItemInterface;

    /**
     * Remove and return the last value in the collection
     * @return CollectionItemInterface
     */
    function pop(): CollectionItemInterface;

    /**
     * Return the first item in the collection without removing it
     * @return CollectionItemInterface
     */
    function first(): CollectionItemInterface;

    /**
     * Return the last item in the collection without removing it
     * @return CollectionItemInterface
     */
    function last(): CollectionItemInterface;

    /**
     * Find a collection item by its object ID
     * @param CollectionItemInterface $collectionItem
     * @return CollectionItemInterface|null
     */
    function find(CollectionItemInterface $collectionItem): ?CollectionItemInterface;

    /**
     * Find many items by their key's data
     * @param mixed $key the key data
     * @param bool $strict if true, the data type must match
     * @return CollectionInterface
     */
    function findByKey(mixed $key, bool $strict=false): CollectionInterface;

    /**
     * Find many items by the key's data type
     * @param string|class-string $keyType the key's data type
     * @return CollectionInterface
     */
    function findByKeyType(string $keyType): CollectionInterface;

    /**
     * Find many items by the value's data
     * @param mixed $value
     * @param bool $strict if true, the value's data type must match
     * @return CollectionInterface
     */
    function findByValue(mixed $value, bool $strict=false): CollectionInterface;

    /**
     * Find many items by the value's data type
     * @param string|class-string $valueType the value's data type
     * @return CollectionInterface
     */
    function findByValueType(string $valueType): CollectionInterface;

    /**
     * Reduce a collection to only the items that cause the callable to return true
     * @param callable $filter Callback is given the CollectionItemInterface and expected to return a boolean.
     * When the callback returns true, the CollectionItem is returned in the resulting Collection.  If the callback
     * returns false, that item is not included in the resulting collection
     * @return self
     */
    function filter(callable $filter):self;



}