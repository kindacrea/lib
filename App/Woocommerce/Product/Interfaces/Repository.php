<?php
namespace Kcpck\App\Woocommerce\Product\Interfaces;

interface Repository
{
    public function getAll(array $categoryIds = []): array;
}
