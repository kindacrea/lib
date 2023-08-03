<?php
namespace Kcpck\App\Interfaces;

use Kcpck\App\Wordpress\Interfaces\Factory as WordpressFactory;
use Kcpck\App\Woocommerce\Interfaces\Factory as WoocommerceFactory;
use Kcpck\App\Collection\Interfaces\Collection;

interface Factory
{
    public function wordpress(): WordpressFactory;
    public function woocommerce(): WoocommerceFactory;
    public function collection(array $items = []): Collection;
    public function getPluginSlug(): string;
}
