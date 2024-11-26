<?php

namespace Foamycastle\Collection;

interface CollectionItemInterface extends \Stringable
{
    function getKey():mixed;
    function getValue():mixed;
    function setKey(mixed $key):self;
    function setValue(mixed $value):self;
    function getKeyType():string;
    function getValueType():string;

    /**
     * Return the object's unique id string
     * @return string
     */
    function getObjectId():string;
    function tuple():array;
}