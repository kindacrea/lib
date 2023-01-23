<?php
namespace Kcpck\App\Wordpress;

class Factory implements Interfaces\Factory
{
    /**
     * @var string
     */
    private $pluginSlug;

    /**
     * @param string $pluginSlug
     */
    public function __construct(string $pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
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
        return get_option($this->pluginSlug . '_' . $key);
    }
}
