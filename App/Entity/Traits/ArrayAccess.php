<?php
namespace Kcpck\App\Entity\Traits;

trait ArrayAccess
{
	/**
	 * @param $offset
	 * @param $value
	 */
	public function offsetSet($offset, $value): void
    {
		if (is_null($offset)) {
			$this->record[] = $value;
		} else {
			$this->record[$offset] = $value;
		}
	}

	/**
	 * @param $offset
	 * @return bool
	 */
	public function offsetExists($offset): bool
    {
		return isset($this->record[$offset]);
	}

	/**
	 * @param $offset
	 */
	public function offsetUnset($offset): void
    {
		unset($this->record[$offset]);
	}

	/**
	 * @param $offset
	 * @return mixed|null
	 */
	public function offsetGet($offset)
    {
		return $this->record[$offset] ?? null;
	}
}
