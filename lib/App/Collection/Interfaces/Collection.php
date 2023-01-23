<?php
namespace Kcpck\App\Collection\Interfaces;

interface Collection extends \Iterator, \Countable, \ArrayAccess
{
    public function set(array $items): void;
    public function sortAsc(callable $selector): Collection;
    public function sortDesc(callable $selector): Collection;
    public function pluck(callable $instance): Collection;
    public function count(): int;
    public function toArray(bool $indexed = false): array;
    public function implode(string $separator): string;
    public function explode(string $text, string $separator = ','): Collection;
    public function byKey(string $key);
    public function first();
    public function last();
    public function slice(int $offset, int $length): Collection;
    public function empty(): bool;
    public function notEmpty(): bool;
    public function filter(callable $item): Collection;
    public function map(callable $items): Collection;
    public function toList(callable $key, callable $value, bool $append_items = false): Collection;
    public function splice(int $offset, int $length, $replacement): Collection;
    public function shuffle($times = 1): Collection;
    public function find($value, string $field): Collection;
    public function append($item): Collection;
    public function merge(Collection $collection): Collection;
    public function contains(callable $field, $value): bool;
}
