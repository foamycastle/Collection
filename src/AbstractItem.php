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
        $this->key=$key;
        return $this;
    }

    function withValue(mixed $value): ItemInterface
    {
        $this->value=$value;
        return $this;
    }

    function withMeta(array $meta): ItemInterface
    {
        $this->meta=$meta;
        return $this;
    }


}