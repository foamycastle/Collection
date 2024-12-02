<?php

namespace Foamycastle\Collection;

interface CollectionInterface extends \IteratorAggregate, \Countable, \ArrayAccess
{
    function add($item):void;
    function remove(string|int $key):void;
    function has(string|int $key):bool;
    function getKeys():iterable;
    function getValues():iterable;
    function getKeysWithObjectId():iterable;
    function getValuesWithObjectId():iterable;
    function findFirstByKey(string|int $key):?CollectionItemInterface;
    function findFirstByValue(mixed $value):?CollectionItemInterface;
    function findFirstByObjectId(string $objectId):?CollectionItemInterface;
    function findAnyByKey(string|int $key):array;
    function findAnyByValue(string|int $value):array;

}