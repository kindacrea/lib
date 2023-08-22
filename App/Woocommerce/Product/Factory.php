<?php
namespace Kcpck\App\Woocommerce\Product;

use Kcpck\App\Interfaces\Factory as BaseFactory;

class Factory implements Interfaces\Factory
{
    /**
     * @var BaseFactory
     */
    private $baseFactory;

    /**
     * @param BaseFactory $baseFactory
     */
    public function __construct(BaseFactory $baseFactory)
    {
        $this->baseFactory = $baseFactory;
    }

    /**
     * @return Category\Interfaces\Factory
     */
    public function category(): Category\Interfaces\Factory
    {
        return new Category\Factory($this->baseFactory);
    }

    /**
     * @return Interfaces\Repository
     */
    public function repository(): Interfaces\Repository
    {
        return new Repository();
    }
}
