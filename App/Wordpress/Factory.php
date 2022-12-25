<?php
namespace Kcpck\App\Wordpress;

class Factory implements Interfaces\Factory
{
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
    public function get_option(string $key)
    {
        return get_option($key);
    }
}
