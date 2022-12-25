<?php
namespace Kcpck\App\Woocommerce\Product\Interfaces;

use Kcpck\App\Woocommerce\Product\Category\Interfaces\Factory as CategoryFactory;

interface Factory
{
    public function category(): CategoryFactory;
}
