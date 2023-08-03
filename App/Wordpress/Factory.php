<?php
namespace Kcpck\App\Wordpress;

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
     * @return Post\Interfaces\Factory
     */
    public function post(): Post\Interfaces\Factory
    {
        return new Post\Factory($this->baseFactory);
    }

    /**
     * @return \wpdb
     */
    public function db(): \wpdb
    {
        global $wpdb;
        return $wpdb;
    }

    /**
     * @param string $key
     * @return false|mixed|null
     */
    public function getOption(string $key)
    {
        return get_option($this->baseFactory->getPluginSlug() . '_' . $key);
    }
}
