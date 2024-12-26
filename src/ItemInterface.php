<?php

namespace Foamycastle\Collection;

interface ItemInterface
{
    function getKey(): string;
    function getValue():mixed;
    function getMeta(): array;
    function withKey(string $key): ItemInterface;
    function withValue(mixed $value): ItemInterface;
    function withMeta(array $meta): ItemInterface;
}