<?php
namespace Kcpck\Collection\Interfaces;

interface Mapper
{
    public function mapEntityToCollection(array $records): Collection;
}
