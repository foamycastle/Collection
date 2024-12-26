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
}