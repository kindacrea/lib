<?php
namespace Kcpck\App\Woocommerce\Product\Category;

class Factory implements Interfaces\Factory
{
    /**
     * @return Interfaces\Repository
     */
    public function repository(): Interfaces\Repository
    {
        return new Repository();
    }
}
