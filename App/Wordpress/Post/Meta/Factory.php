<?php
namespace Kcpck\App\Wordpress\Post\Meta;

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
     * @return Interfaces\Repository
     */
    public function repository(): Interfaces\Repository
    {
        return new Repository($this->baseFactory);
    }
}
