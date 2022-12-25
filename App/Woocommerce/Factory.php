<?php
namespace Kcpck\App\Woocommerce;

class Factory implements Interfaces\Factory
{
    /**
     * @return Product\Interfaces\Factory
     */
    public function product(): Product\Interfaces\Factory
    {
        return new Product\Factory();
    }
}
