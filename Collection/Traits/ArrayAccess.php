<?php
namespace Kcpck\Collection\Traits;

trait ArrayAccess
{
	/**
	 * @param $offset
	 * @param $value
	 */
	public function offsetSet($offset, $value): void
    {
		if (is_null($offset)) {
			$this->items[] = $value;
		} else {
			$this->items[$offset] = $value;
		}
	}

	/**
	 * @param $offset
	 * @return bool
	 */
	public function offsetExists($offset): bool
    {
		return isset($this->items[$offset]);
	}

	/**
	 * @param $offset
	 */
	public function offsetUnset($offset): void
    {
		unset($this->items[$offset]);
	}

	/**
	 * @param $offset
	 * @return mixed|null
	 */
	public function offsetGet($offset)
    {
		return $this->items[$offset] ?? null;
	}
}
