<?php
namespace Kcpck\App\Woocommerce\Product;

class Repository implements Interfaces\Repository
{
    /**
     * @param array $categoryIds
     * @return array
     */
    public function getByCategoryIds(array $categoryIds): array
    {
        return (new \WP_Query([
            'post_status' => 'publish',
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
