<?php
namespace Kcpck\App\Woocommerce\Product;

class Factory implements Interfaces\Factory
{
    /**
     * @return Category\Interfaces\Factory
     */
    public function category(): Category\Interfaces\Factory
    {
        return new Category\Factory();
    }
}
