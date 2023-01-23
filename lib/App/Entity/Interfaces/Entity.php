<?php
namespace Kcpck\App\Entity\Interfaces;

interface Entity
{
	public function getId(): int;
    public function setId(int $value): self;
    public function toArray(): array;
}
