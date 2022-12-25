<?php
namespace Kcpck\App\Wordpress\Interfaces;

interface Factory
{
    public function db(): \wpdb;
    public function get_option(string $key);
}
