<?php
namespace Kcpck\App\Woocommerce\Product;

class Repository implements Interfaces\Repository
{
    /**
     * @param array $categoryIds
     * @return array
     */
    public function getAll(array $categoryIds = []): array
    {
        $params = [
            'status' => 'publish',
            'limit' => -1,
            'orderby' => 'name',
            'order' => 'ASC'
        ];

        $categorySlugs = array_map(
            function ($categoryId) {
                $category = get_term($categoryId, 'product_cat');
                return $category->slug;
            },
            $categoryIds
        );

        if (!empty($categorySlugs)) {
            $params['category'] = $categorySlugs;
        }

        return wc_get_products($params);
    }
}
