<?php

namespace Foamycastle\Collection;

interface CollectionInterface extends \Iterator, \Countable, \ArrayAccess
{
    /**
     * Set the data with the key matches
     * @param mixed $whereKey the key to find and match
     * @param mixed $value The value to place where key matches
     * @param bool $strict if TRUE, the key must be of the same type
     * @return  self
     */
    function setDataWhereKey(mixed $whereKey, mixed $value, bool $strict = false): self;

    /**
     * Sets the key where data matches
     * @param mixed $key The key to place in the collection
     * @param mixed $whereValue The value to find and match
     * @param bool $strict if TRUE, the value must be of the same type
     * @return  self
     */
    function setKeyWhereData(mixed $key, mixed $whereValue, bool $strict = false): self;

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
     * Identify collection items whose data match the supplied criteria.  Comparison between items and criteria are strict.
     * @param mixed $data The data to match
     * @param mixed|null $key Optional.  If the key is also supplied, both the data and the key must match on a strict type basis
     * @return self A new collection is returned with the matching results
     */
    function findDataWhere(mixed $data, mixed $key = null): self;

    /**
     * Identify collection items whose key match the supplied criteria.  Comparison between items and criteria are strict.
     * @param mixed $key the key to find and match
     * @param mixed|null $data Optional.  If the data argument is also supplied, both the key and the data must match on a strict type basis
     * @return self A new collection is returned with the matching results
     */
    function findKeysWhere(mixed $key, mixed $data = null): self;




}