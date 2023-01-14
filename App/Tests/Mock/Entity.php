<?php
namespace Kcpck\App\Tests\Mock;

class Entity extends \Kcpck\App\Entity\Entity
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->record['name'] ?? '';
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}
