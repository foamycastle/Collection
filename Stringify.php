<?php

namespace Foamycastle\Collection;

use ReflectionProperty;

/**
 * Converts any object or data type into a string
 */
class Stringify implements \Stringable
{
    public function __construct(protected readonly mixed $object)
    {
    }
    public function __toString(): string
    {
        switch (gettype($this->object)) {
            case 'string':
            case 'integer':
            case 'double':
                return (string)$this->object;
            case 'array':
                return print_r($this->object,true);
            case 'boolean':
                return $this->object ? 'true' : 'false';
            case 'NULL':
                return 'null';
            case 'object':
            try{
                return (string)$this->object;
            }catch (\Exception $e){
                try{
                    $reflect = new \ReflectionObject($this->object);
                }catch (\ReflectionException $e){
                    return $this->object::class;
                }
                $properties=$reflect->getProperties(ReflectionProperty::IS_PUBLIC);
                return print_r(
                    array_map(
                        function (ReflectionProperty $property) {
                            try{
                                return $property->getName.": ".(string)$property->getValue($this->object);
                            }catch (\Exception $e){
                                return $property->getName().": ";
                            }
                        }
                    ,$properties),
                    true
                );
            }

        }
    }
}