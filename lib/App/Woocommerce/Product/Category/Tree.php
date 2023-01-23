<?php
namespace Kcpck\App\Woocommerce\Product\Category;

/**
 * @method \WP_Term current
 */
class Tree
{
    private $branchCategoryIds = [];
    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $tree = $this->buildTree($data);
        $this->extractMainCategoryBranchIds($tree);
        $this->setData($tree);
    }

    /**
     * @param array $data
     * @return void
     */
    private function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $productCategories
     * @param int $parentId
     * @return array
     */
    private function buildTree(array $productCategories, int $parentId = 0) : array
    {
        $branch = [];
        foreach ($productCategories as $productCategory) {
            if ($productCategory->parent === $parentId) {
                $children = $this->buildTree($productCategories, $productCategory->term_id);
                $productCategory->children = [];
                if (!empty($children)) {
                    $productCategory->children = $children;
                }
                $branch[] = $productCategory;
            }
        }
        return $branch;
    }

    /**
     * @param $productCategories
     */
    private function extractMainCategoryBranchIds($productCategories) : void
    {
        foreach ($productCategories as $productCategory)
        {
            if (!empty($productCategory->children)) {
                $this->extractSubCategoryIds($productCategory->children, $productCategory->term_id);
            }
        }
    }

    /**
     * @param $productCategories
     * @param $mainCategoryId
     * @return void
     */
    private function extractSubCategoryIds($productCategories, $mainCategoryId) : void
    {
        foreach ($productCategories as $productCategory) {
            $this->branchCategoryIds[$mainCategoryId][] = $productCategory->term_id;
            if (!empty($productCategory->children)) {
                $this->extractSubCategoryIds($productCategory->children, $mainCategoryId);
            }
        }
    }
}
