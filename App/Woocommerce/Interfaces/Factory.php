<?php
namespace Kcpck\App\Woocommerce\Interfaces;

use Kcpck\App\Woocommerce\Product\Interfaces\Factory as ProductFactory;

interface Factory
{
    public function product(): ProductFactory;
}
