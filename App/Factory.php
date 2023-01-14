<?php
namespace Kcpck\App;

use Kcpck\App\Collection;
use Kcpck\App\Wordpress;
use Kcpck\App\Woocommerce;

class Factory implements Interfaces\Factory
{
    private static $instance;

    /**
     * @return static
     */
    public static function make(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $pluginSlug
     * @return Wordpress\Interfaces\Factory
     */
    public function wordpress(string $pluginSlug): Wordpress\Interfaces\Factory
    {
        return new Wordpress\Factory($pluginSlug);
    }

    /**
     * @return Woocommerce\Interfaces\Factory
     */
    public function woocommerce(): Woocommerce\Interfaces\Factory
    {
        return new Woocommerce\Factory($this);
    }

    /**
     * @param array $items
     * @return Collection\Interfaces\Collection
     */
    public function collection(array $items = []): Collection\Interfaces\Collection
    {
        return new Collection\Collection($items);
    }
}
