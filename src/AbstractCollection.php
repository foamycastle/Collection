<?php

namespace Foamycastle\Collection;

abstract class AbstractCollection implements \Countable, \IteratorAggregate
{
    /**
     * The collection of items
     * @var array
     */
    protected array $items = [];
    /**
     * Collection metadata
     * @var list<string,mixed>
     */
    protected array $data = [];
    /**
     * Optional name of the collection
     * @var string
     */
    protected string $name;

    /**
     * Append an item to the collection
     * @param mixed ...$items
     * @return $this
     */
    abstract public function append(...$items): static;

    /**
     * Prepend an item to the collection
     * @param mixed $item
     * @return $this
     */
    abstract public function prepend(...$items): static;

    /**
     * Remove an item from the collection
     * @param mixed $id the identifier by the which the item is known
     * @return bool TRUE if an item was removed, FALSE if no item was removed
     */
    abstract public function remove(mixed $id): bool;

    /**
     * Indicate that collection item exists
     * @param mixed $id The identifier by which to locate the item
     * @return bool TRUE if the item exists
     */
    abstract public function has(mixed $id): bool;

    /**
     * Find and return the first item that matches the criteria
     * @param mixed ...$criteria Search criteria
     * @return mixed The search results
     */
    abstract public function findFirst(...$criteria): mixed;

    /**
     * Find all the items that match the given criteria
     * @param ...$criteria
     * @return mixed
     */
    abstract public function findAll(...$criteria): mixed;

    /**
     * A sorting algorithm
     * @param ...$args
     * @return $this
     */
    abstract public function sort(...$args): static;

    /**
     * Get or set collection metadata.  Get data by passing the first argument alone, Set by passing 2 arguments: first, the identifier; second, the data.
     * @param string $id The metadata key
     * @param mixed|null $value the value of the data
     * @return mixed Returns either the value of the supplied key or `null` if the second argument is present, or if the key does not exist
     */
    public function meta(string $id, mixed $value=null):mixed
    {
        if($value === null){
            return $this->data[$id] ?? null;
        }
        $this->data[$id] = $value;
        return null;
    }
    public function count(): int
    {
        return count($this->items);
    }
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

}