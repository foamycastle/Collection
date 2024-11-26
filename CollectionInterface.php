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
     * Verify a collection contains a key.
     * @param mixed $key The key to verify
     * @return bool TRUE if key exists in collection
     */
    function hasKey(mixed $key): bool;

    /**
     * Reduce a collection to only the items that cause the callable to return true
     * @param callable $filter Callback is given the CollectionItemInterface and expected to return a boolean.
     * When the callback returns true, the CollectionItem is returned in the resulting Collection.  If the callback
     * returns false, that item is not included in the resulting collection
     * @return self
     */
    function filter(callable $filter):self;



}