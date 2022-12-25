<?php
namespace Kcpck\Collection;

use JsonException;
use Kcpck\Collection\Traits\Iterator;
use Kcpck\Collection\Traits\Countable;
use Kcpck\Collection\Traits\ArrayAccess;
use Kcpck\Exception\emptyCollectionException;

class Collection implements Interfaces\Collection
{
    use ArrayAccess, Iterator, Countable;

    protected $items = [];

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->set($items);
    }

    /**
     * @param array $items
     */
    public function set(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @param callable $selector
     * @return Collection
     */
    public function sortAsc(callable $selector): Interfaces\Collection
    {
        $this->sort($selector);
        return $this;
    }

    /**
     * @param callable $selector
     * @return Collection
     */
    public function sortDesc(callable $selector): Interfaces\Collection
    {
        $this->sort($selector, false);
        return $this;
    }

    /**
     * Example:
     * $test = new TestCollection();
     * $test->sort(function(entity $entity) {
     *    return $entity->id;
     * });
     *
     * @param callable $selector
     * @param bool $direction_asc
     * @return void
     */
    private function sort(callable $selector, bool $direction_asc = true): void
    {
        usort($this->items, static function ($a, $b) use ($selector, $direction_asc) {
            if ($direction_asc) {
                return strnatcasecmp(
                    $selector($a),
                    $selector($b)
                );
            }
            return strnatcasecmp(
                $selector($b),
                $selector($a)
            );
        });
    }

    /**
     * Example:
     * $test = new TestCollection();
     * $names = $collection->pluck(function($instance) {
     *    return $instance['name'] ?? null;
     * });
     *
     * @param callable $instance
     * @return Interfaces\Collection
     */
    public function pluck(callable $instance): Interfaces\Collection
    {
        $values = [];
        foreach ($this->items as $item) {
            $values[] = $instance($item);
        }
        return new static($values);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * The model needs to implement \JsonSerializable and
     * use the method "jsonSerialize" for this to work.
     *
     * @param bool $indexed
     * @return array
     * @throws JsonException
     */
    public function toArray(bool $indexed = false): array
    {
        $encoded = json_encode($this->items, JSON_THROW_ON_ERROR);
        $items = json_decode($encoded, true, 512, JSON_THROW_ON_ERROR);

        if ($indexed) {
            return array_values($items);
        }

        return $items;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function implode(string $separator): string
    {
        return implode($separator, $this->items);
    }

    /**
     * Adds a string of items to the collection
     * PTODO: missing test
     *
     * @param string $text
     * @param string $separator
     * @return Interfaces\Collection
     */
    public function explode(string $text, string $separator = ','): Interfaces\Collection
    {
        foreach (explode($separator, $text) as $item) {
            $this->append(trim($item));
        }
        return $this;
    }

    /**
     * @throws emptyCollectionException
     */
    public function byKey(string $key)
    {
        if ($this->empty()) {
            throw new emptyCollectionException('Key not found in collection');
        }

        return $this->items[$key] ?? null;
    }

    /**
     * @return false|mixed
     * @throws emptyCollectionException
     */
    public function first()
    {
        if ($this->empty()) {
            throw new emptyCollectionException('No first item in collection');
        }

        return reset($this->items);
    }

    /**
     * @return false|mixed
     * @throws emptyCollectionException
     */
    public function last($optional = false)
    {
        if ($this->empty()) {
            throw new emptyCollectionException('No last item in collection');
        }

        return end($this->items);
    }

    /**
     * @param int $offset
     * @param int $length
     *
     * @return Interfaces\Collection
     */
    public function slice(int $offset, int $length): Interfaces\Collection
    {
        $this->items = array_values(array_slice($this->items, $offset, $length));
        return $this;
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->items);
    }

    /**
     * PTODO: missing test
     * @return bool
     */
    public function notEmpty(): bool
    {
        return !$this->empty();
    }

    /**
     * @param callable $item
     * @return Interfaces\Collection
     */
    public function filter(callable $item): Interfaces\Collection
    {
        return new static(array_filter($this->items, $item));
    }

    /**
     * @param callable $items
     * @return $this
     */
    public function map(callable $items): Interfaces\Collection
    {
        return new static(array_map($items, $this->items));
    }

    /**
     * Example:
     * $test = new TestCollection();
     * $list = $collection->to_list(
     *    function($item){
     *       return $item->id;
     *    },
     *    function($item){
     *       return $item->name;
     *    }
     * );
     *
     * @param callable $key
     * @param callable $value
     * @param bool $append_items
     * @return Interfaces\Collection
     */
    public function toList(callable $key, callable $value, bool $append_items = false): Interfaces\Collection
    {
        $items = [];
        foreach ($this->items as $instance) {
            if (!$append_items) {
                $items[$key($instance)] = $value($instance);
            } else {
                $items[$key($instance)][] = $value($instance);
            }
        }
        return new static($items);
    }

    /**
     * PTODO: missing test
     */
    public function splice(int $offset, int $length, $replacement): Interfaces\Collection
    {
        $items = array_splice($this->items, $offset, $length, $replacement);
        return new static($items);
    }

    /**
     * @param int $times
     * @return Interfaces\Collection
     */
    public function shuffle($times = 1): Interfaces\Collection
    {
        for ($i = 0; $i < $times; $i++) {
            shuffle($this->items);
        }
        return $this;
    }

    /**
     * @param $value
     * @param string $field
     * @return Interfaces\Collection
     */
    public function find($value, string $field = ''): Interfaces\Collection
    {
        $found = [];
        foreach ($this as $item) {
            if (
                (is_object($item) && isset($item->$field) && $item->$field == $value) ||
                (is_array($item) && isset($item[$field]) && $item[$field] == $value) ||
                ($item == $value && empty($field))
            ) {
                $found[] = $item;
            }
        }

        return new static($found);
    }

    /**
     * @param $item
     * @return Interfaces\Collection
     * @deprecated Replaced with the append($item) method
     *
     */
    public function add($item): Interfaces\Collection
    {
        return $this->append($item);
    }

    /**
     * @param $item
     * @return Interfaces\Collection
     */
    public function append($item): Interfaces\Collection
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param $item
     * @return $this
     */
    public function prepend($item): Collection
    {
        array_unshift($this->items, $item);
        return new static($this->items);
    }

    /**
     * PTODO: This could maybe be optimized with $this->items = $this->items[...$collection->to_array()];
     *
     * @param Interfaces\Collection $collection
     * @return Interfaces\Collection
     */
    public function merge(Interfaces\Collection $collection): Interfaces\Collection
    {
        foreach ($collection as $item) {
            $this->append($item);
        }
        return $this;
    }

    /**
     * @param callable $field
     * @param $value
     * @return bool
     */
    public function contains(callable $field, $value): bool
    {
        foreach ($this->items as $item) {
            if ($field($item) === $value) {
                return true;
            }
        }
        return false;
    }
}
