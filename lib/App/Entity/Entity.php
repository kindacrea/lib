<?php
namespace Kcpck\App\Entity;

use Kcpck\App\Entity\Traits\ArrayAccess;
use Kcpck\App\Entity\Traits\Accessor;

abstract class Entity extends \stdClass implements interfaces\entity, \ArrayAccess, \JsonSerializable
{
	use ArrayAccess, Accessor;

    protected $record;

    /**
     * @param array $record
     */
    public function __construct(array $record = [])
    {
        $this->record = $record;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->record['id'] ?? 0;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function setId(int $value): self
    {
        $this->record['id'] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract public function toArray(): array;
}
