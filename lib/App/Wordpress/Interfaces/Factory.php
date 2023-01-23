<?php
namespace Kcpck\App\Wordpress\Interfaces;

interface Factory
{
    public function db(): \wpdb;
    public function getOption(string $key);
}
