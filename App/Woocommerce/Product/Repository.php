<?php
namespace Kcpck\App\Woocommerce\Product;

class Repository implements Interfaces\Repository
{
    /**
     * @return array
     */
    public function getAll(): array
    {
        return wc_get_products([
            'status' => 'publish',
            'limit' => -1,
            'orderby' => 'name',
            'order' => 'ASC',
        ]);
    }

    /**
     * @param array $categoryIds
     * @return array
     */
    public function getByCategoryIds(array $categoryIds): array
    {
        return (new \WP_Query([
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => implode(',', $categoryIds),
                    'operator' => 'IN'
                ]
            ]
        ]))->get_posts();
    }
}
