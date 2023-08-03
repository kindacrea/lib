<?php
namespace Kcpck\App;

use Kcpck\App\Collection;
use Kcpck\App\Wordpress;
use Kcpck\App\Woocommerce;

class Factory implements Interfaces\Factory
{
    private static $instance;
    private $pluginSlug;

    /**
     * @param string $pluginSlug
     */
    private function __construct(string $pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
    }

    /**
     * @return static
     */
    public static function make(string $pluginSlug): self
    {
        if (self::$instance === null) {
            self::$instance = new self($pluginSlug);
        }
        return self::$instance;
    }

    /**
     * @return Wordpress\Interfaces\Factory
     */
    public function wordpress(): Wordpress\Interfaces\Factory
    {
        return new Wordpress\Factory($this);
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

    /**
     * @return string
     */
    public function getPluginSlug(): string
    {
        return $this->pluginSlug;
    }
}
