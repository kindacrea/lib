<?php
namespace Kcpck\App\Woocommerce\Product\Interfaces;

interface Repository
{
    public function getAll(): array;
    public function getByCategoryIds(array $categoryIds): array;
}
