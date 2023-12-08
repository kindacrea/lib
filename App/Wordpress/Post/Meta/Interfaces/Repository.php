<?php
namespace Kcpck\App\Wordpress\Post\Meta\Interfaces;

use Kcpck\App\Collection\Interfaces\Collection;

interface Repository
{
    public function getAll(array $postMetaFieldKeys, string $postType = 'post', string $postStatus = 'publish',
                           ?int $postId = null, string $orderBy = 'pm.post_id', string $orderDir = 'ASC'): Collection;
    public function getAllByMetaIdentifier(string $uniqueId, string $uniqueColumn, array $postMetaFieldKeys,
                                           string $postType = 'post', string $postStatus = 'publish'): Collection;
}
