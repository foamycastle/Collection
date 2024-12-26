<?php

namespace Foamycastle\Collection;

abstract class AbstractItem implements ItemInterface
{
    public function __construct(
        protected string $key,
        protected mixed $value,
        protected array $meta = [],
    )
    {
    }

    function getKey(): string
    {
        return $this->key;
    }

    function getValue(): mixed
    {
        return $this->value;
    }

    function getMeta(): array
    {
        return $this->meta;
    }

    function withKey(string $key): ItemInterface
    {
        return new static($key, $this->value, $this->meta);
    }

    function withValue(mixed $value): ItemInterface
    {
        return new static($this->key, $value, $this->meta);
    }

    function withMeta(array $meta): ItemInterface
    {
        return new static($this->key, $this->value, $meta);
    }


}