<?php
namespace Kcpck\App\Woocommerce\Product\Category;

class Repository implements Interfaces\Repository
{
    private static $productCategories = null;

    /**
     * //Todo: Convert to collection
     *
     * @return array
     */
    public function getAll() : array
    {
        if (self::$productCategories !== null) {
            return self::$productCategories->get();
        }

        self::$productCategories = new Tree(get_terms( 'product_cat', [
            'number'     => '',
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => true
        ]));

        return self::$productCategories->get();
    }
}
