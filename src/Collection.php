<?php

namespace Foamycastle\Collection;

class Collection extends AbstractCollection
{
    public function __construct(string $name='')
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function has(mixed $id): bool
    {
        return isset($this->items[$id]);
    }

    /**
     * @param array{'key':string,'value':mixed}|array<string,mixed>...$criteria
     * @return mixed
     */
    public function findFirst(...$criteria): mixed
    {
        //find named arguments first (key: locate_this_key, value: locate_this_value)
        if(isset($criteria['key'])) {
            $key = $criteria['key'];
        }
        if(isset($criteria['value'])) {
            $value = $criteria['value'];
        }

        //if no named arguments, look for an associative array [$key => $value]
        if(@array_is_list($criteria) && isset($criteria[0])) {
            if(is_string(key($criteria[0]))) {
                $key = key($criteria[0]);
            }else{
                $key=false;
            }
            $value = current($criteria[0]);
        }
        // if no associative array, look for a named arguments where the
        // key to locate is the argument name and the value is the argument value (locate_this_key: locate_this_value)
        if(!isset($key) && !isset($value)) {
            if(is_string(key($criteria))) {
                $key = key($criteria);
                $value = current($criteria) ?? null;
            }else {
                return null;
            }
        }
        //determine which scenario is true, then test
        switch (true){
            case (isset($key) && isset($value)):
                return $this->items[$key]===$value
                    ? $this->items[$key]
                    : null;
            case (!isset($value) && isset($key)):
                return $this->items[$key] ?? null;
            case (!isset($key) && isset($value)):
                $search=array_search($value, $this->items, true);
                return $search
                    ? $this->items[$search]
                    : null;
            default:
                return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function findAll(...$criteria): mixed
    {

    }


    /**
     * @inheritDoc
     */
    public function sort(...$args): static
    {
        // TODO: Implement sort() method.
    }

    public function append(...$items): static
    {
        if(count($items) == 2) {
            if(array_key_exists('key', $items) && array_key_exists('value', $items)) {
                $this->items[$items['key']] = $items['value'];
                return $this;
            }
            if(is_string($items[0])){
                $this->items[$items[0]] = $items[1];
                return $this;
            }
        }
        foreach($items as $key => $value) {
            if($key=='key'){
                $addKey=$value;
            }elseif($key=='value'){
                $addValue=$value;
            }else{
                $addKey=$key;
                $addValue=$value;
            }
            if(is_array($addValue)) {
                $addKey = key($addValue) ?: $addValue[0];
                $addValue = current ($addValue) ?? $addValue[1];
            }
            if(empty($addKey)) return $this;
            $this->items[$addKey]=$addValue;
        }
        return $this;
    }

    public function prepend(...$items): static
    {
        if(count($items) === 2){
            if(array_key_exists('key', $items) && array_key_exists('value', $items)){
                $this->items=array_merge([ $items['key'] => $items['value'] ], $this->items);
                return $this;
            }
        }
        if(array_is_list($items)){
            $this->items = array_merge($items, $this->items);
            return $this;
        }
        foreach($items as $key=>$item){
            array_unshift($this->items, [ $key => $item ]);
        }
        return $this;
    }

    public function removeFirst(mixed $id): bool
    {
        // TODO: Implement remove() method.
    }

    public function removeAll(mixed $id): bool
    {
        // TODO: Implement removeAll() method.
    }


}