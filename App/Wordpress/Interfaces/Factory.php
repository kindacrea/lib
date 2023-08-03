<?php
namespace Kcpck\App\Wordpress\Interfaces;

use Kcpck\App\Wordpress\Post\Interfaces\Factory as PostFactory;

interface Factory
{
    public function post(): PostFactory;
    public function db(): \wpdb;
    public function getOption(string $key);
}
