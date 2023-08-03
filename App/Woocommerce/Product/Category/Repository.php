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

    private $childCategories;

    /**
     * @param Collection $categories
     * @param int $categoryId
     * @param bool $recursive
     * @return Collection
     */
    public function getChildrenByCategoryId(Collection $categories, int $categoryId, bool $recursive = false): Collection
    {
        if (empty($this->childCategories)) {
            $this->childCategories = self::$baseFactory->collection();
        }
        foreach ($categories as $category) {
            if (empty($category->children)) {
                continue;
            }
            if ($category->term_id === $categoryId) {
                $this->childCategories = self::$baseFactory->collection($category->children);
            } else if ($recursive) {
                $this->getChildrenByCategoryId(self::$baseFactory->collection($category->children), $categoryId, $recursive);
            }
        }
        return $this->childCategories;
    }
}
