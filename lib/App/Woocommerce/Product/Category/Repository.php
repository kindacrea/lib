<?php
namespace Kcpck\App\Woocommerce\Product\Category;

use Kcpck\App\Collection\Interfaces\Collection;
use Kcpck\App\Interfaces\Factory as BaseFactory;

class Repository implements Interfaces\Repository
{
    private static $productCategories;
    private static $baseFactory;

    /**
     * @param BaseFactory $baseFactory
     */
    public function __construct(BaseFactory $baseFactory)
    {
        self::$baseFactory = $baseFactory;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        if (self::$productCategories !== null) {
            return self::$baseFactory->collection(self::$productCategories->getData());
        }

        self::$productCategories = new Tree(get_terms('product_cat', [
            'number'     => '',
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => true
        ]));

        return self::$baseFactory->collection(self::$productCategories->getData());
    }
}
