<?php
namespace Kcpck\App\Collection\Interfaces;

interface Mapper
{
    public function mapEntityToCollection(array $records): Collection;
}
