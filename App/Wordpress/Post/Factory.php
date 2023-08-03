<?php
namespace Kcpck\App\Wordpress\Post;

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
     * @return Meta\Interfaces\Factory
     */
    public function meta(): Meta\Interfaces\Factory
    {
        return new Meta\Factory($this->baseFactory);
    }
}
