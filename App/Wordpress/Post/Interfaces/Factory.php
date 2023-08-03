<?php
namespace Kcpck\App\Wordpress\Post\Interfaces;

use Kcpck\App\Wordpress\Post\Meta\Interfaces\Factory as MetaFactory;

interface Factory
{
    public function meta(): MetaFactory;
}
