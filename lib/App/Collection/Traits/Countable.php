<?php
namespace Kcpck\App\Collection\Traits;

trait Countable
{
    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }
}
