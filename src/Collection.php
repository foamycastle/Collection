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
        foreach ($this->items as $item) {
            if(key($item) === $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array{'key':string,'value':mixed}|array<string,mixed>...$criteria
     * @return array
     */
    public function findFirst(...$criteria): array
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
                return [];
            }
        }
        //determine which scenario is true, then test
        return (match(true){
            ((isset($key) && is_array($key)) && (isset($value) && is_array($value))) => function() use ($key, $value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if(in_array($itemKey, $key) || in_array($itemValue, $value)) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            ((isset($key) && is_array($key)) && (isset($value) && is_scalar($value))) => function() use ($key, $value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if(in_array($itemKey, $key) || $itemValue===$value) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            ((isset($key) && is_scalar($key)) && (isset($value) && is_array($value))) => function() use ($key, $value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if($itemKey===$key || in_array($itemValue, $value)) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
    },
            ((isset($key) && is_scalar($key)) && (isset($value) && is_scalar($value))) => function() use ($key, $value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if($itemKey===$key || $itemValue===$value) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            (!isset($key)  && (isset($value) && is_scalar($value))) => function() use ($value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if($itemValue===$value) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            (!isset($key)  && (isset($value) && is_array($value))) => function() use ($value) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if(in_array($itemValue, $value)) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            ((isset($key) && is_scalar($key)) && !isset($value)) => function() use ($key) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if($itemKey===$key) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            },
            ((isset($key) && is_array($key)) && !isset($value)) => function() use ($key) {
                foreach($this->items as $item) {
                    [$itemKey, $itemValue] = $item;
                    if(in_array($itemKey, $key)) {
                        return [$itemKey => $itemValue];
                    }
                }
                return [];
            }
        })();
    }

    /**
     * @param array{'key':list<string|int>|string|int,'value':list<string|int>|string|int}|array<list<string|int>,list<string|int>> ...$criteria
     * @return array|null
     */
    public function findAll(...$criteria): ?array
    {
        if(isset($criteria['key']) && is_string($criteria['key'])) {
            $key = $criteria['key'];
        }
        if(isset($criteria['value'])) {
            $value = $criteria['value'];
        }
        if(@array_is_list($criteria)) {
            if(
                count($criteria)==2
                && (is_array($criteria[0]) || is_string($criteria[0]))
                && (is_array($criteria[1]) || is_string($criteria[1]))
            ) {
                $key=$criteria[0];
                $value=$criteria[1];
            }
        }

        return match (true) {
            (isset($key) && is_array($key)) && (isset($value) && is_array($value)) => array_filter(
                $this->items,
                function ($arrayValue,$arrayKey) use ($key, $value) {
                    return in_array($arrayKey,$key) || in_array($arrayValue,$value);
                },
                ARRAY_FILTER_USE_BOTH
            ),
            (isset($key) && is_string($key)) && (isset($value) && is_array($value)) => array_filter(
                $this->items,
                function ($arrayValue,$arrayKey) use ($key, $value) {
                    return in_array($arrayValue,$value) || $arrayKey===$key;
                },
                ARRAY_FILTER_USE_BOTH
            ),
            (isset($key) && is_string($key)) && (isset($value) && is_string($value)) => array_filter(
                $this->items,
                function ($arrayValue,$arrayKey) use ($key, $value) {
                    return $arrayValue===$value || $arrayKey===$key;
                },
                ARRAY_FILTER_USE_BOTH
            ),
            (isset($key) && is_array($key)) && (isset($value) && is_string($value)) => array_filter(
                $this->items,
                function ($arrayValue,$arrayKey) use ($key, $value) {
                    return $arrayValue===$value || in_array($arrayKey,$key);
                },
                ARRAY_FILTER_USE_BOTH
            ),
            ((isset($key) && is_array($key)) && !isset($value)) => array_filter(
                $this->items,
                function ($arrayKey) use ($key) {
                    return in_array($arrayKey,$key);
                },
                ARRAY_FILTER_USE_KEY
            ),
            ((isset($key) && is_string($key)) && !isset($value)) => array_filter(
                $this->items,
                function ($arrayKey) use ($key) {
                    return $arrayKey===$key;
                },
                ARRAY_FILTER_USE_KEY
            ),
            !isset($key) && (isset($value) && is_array($value)) => array_filter(
                $this->items,
                function ($arrayValue) use ($value) {
                    return in_array($arrayValue,$value);
                }
            ),
            !isset($key) && (isset($value) && is_string($value)) => array_filter(
                $this->items,
                function ($arrayValue) use ($value) {
                    return $arrayValue===$value;
                }
            ),
            default => [],
        };
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
        foreach($items as $item) {
            if($item instanceof static) {
                $this->items = array_merge($this->items, $item->items);
                continue;
            }
            if(is_array($item)) {
                if(array_is_list($item)) {
                    $this->items = array_merge($this->items, $item);
                }else{
                    foreach($item as $itemKey=>$itemValue) {
                        $this->items[]=[$itemKey=>$itemValue];
                    }
                }
            }else{
                $this->items[]=$item;
            }
        }
        return $this;
    }

    public function prepend(...$items): static
    {
        foreach ($items as $item) {
            if($item instanceof static) {
                array_unshift($this->items, ...$item->items);
                continue;
            }
            if(is_array($item)) {
                if(array_is_list($item)) {
                    array_unshift($this->items, ...$item);
                }else{
                    foreach($item as $itemKey=>$itemValue) {
                        array_unshift($this->items, [$itemKey=>$itemValue]);
                    }
                }
            }else{
                array_unshift($this->items, [$item]);
            }
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