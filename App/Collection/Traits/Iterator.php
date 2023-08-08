<?php
namespace Kcpck\App\Collection\Traits;

trait Iterator
{
    /**
     * @link http://php.net/manual/en/iterator.current.php
     * @return array Can return any type.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return current($this->items);
    }

    /**
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        return next($this->items);
    }

    /**
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return key($this->items);
    }

    /**
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return array_key_exists(key($this->items), $this->items);
    }

    /**
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        reset($this->items);
    }
}
