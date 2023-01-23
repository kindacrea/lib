<?php
namespace Kcpck\App\Woocommerce;

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
     * @return Product\Interfaces\Factory
     */
    public function product(): Product\Interfaces\Factory
    {
        return new Product\Factory($this->baseFactory);
    }
}
