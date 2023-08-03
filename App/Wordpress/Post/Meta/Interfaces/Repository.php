<?php
namespace Kcpck\App\Wordpress\Post\Meta\Interfaces;

use Kcpck\App\Collection\Interfaces\Collection;

interface Repository
{
    public function getAll(array $postMetaFieldKeys, string $postType = 'post', string $postStatus = 'publish'): Collection;
}
