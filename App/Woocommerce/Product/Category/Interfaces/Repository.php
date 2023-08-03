<?php
namespace Kcpck\App\Woocommerce\Product\Category\Interfaces;

use Kcpck\App\Collection\Interfaces\Collection;

interface Repository
{
    public function getAll(): Collection;
    public function getChildrenByCategoryId(Collection $categories, int $categoryId, bool $recursive = false): Collection;
}
