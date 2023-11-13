<?php
namespace Kcpck\App\Wordpress\Post\Meta;

use Kcpck\App\Collection\Interfaces\Collection;
use Kcpck\App\Interfaces\Factory as BaseFactory;

class Repository implements Interfaces\Repository
{
    /**
     * @var BaseFactory
     */
    private $baseFactory;
    /**
     * @var \wpdb
     */
    private $db;

    /**
     * @param BaseFactory $baseFactory
     */
    public function __construct(BaseFactory $baseFactory)
    {
        $this->baseFactory = $baseFactory;
        $this->db = $baseFactory->wordpress()->db();
    }

    /**
     * @param array $postMetaFieldKeys
     * @param string $postType
     * @param string $postStatus
     * @param int|null $postId
     * @return Collection
     */
    public function getAll(array $postMetaFieldKeys, string $postType = 'post', string $postStatus = 'publish',
                           ?int $postId = null): Collection
    {
        $metaFieldChunks = [];
        foreach ($postMetaFieldKeys as $metaKey) {
            $metaFieldChunks[] = 'pm.meta_key = \'' . $metaKey . '\'';
        }

        $sql = /** @lang mysql */'
        SELECT pm.post_id, pm.meta_key, pm.meta_value 
        FROM ' . $this->db->prefix . 'postmeta pm
        LEFT JOIN ' . $this->db->prefix . 'posts p ON pm.post_id = p.ID AND p.post_status = \'' . $postStatus . '\'
        WHERE p.post_type = \'' . $postType . '\' AND (' . implode(' OR ', $metaFieldChunks) . ')';
        if ($postId !== null) {
            $sql .= ' AND pm.post_id = \'' . $postId . '\'';
        }
        $unstructuredMetaData = $this->db->get_results($sql, OBJECT);

        $postsMetaRecords = [];
        foreach ($unstructuredMetaData as $row) {
            if (!isset($postsMetaRecords[$row->post_id])) {
                $postsMetaRecords[$row->post_id] = [];
            }
            $postsMetaRecords[$row->post_id][$row->meta_key] = $row->meta_value;
        }

        return $this->baseFactory->collection($postsMetaRecords);
    }

    /**
     * @param int $uniqueId
     * @param string $uniqueColumn
     * @param array $postMetaFieldKeys
     * @param string $postType
     * @param string $postStatus
     * @return Collection
     */
    public function getAllByMetaIdentifier(int $uniqueId, string $uniqueColumn, array $postMetaFieldKeys,
                                           string $postType = 'post', string $postStatus = 'publish'): Collection
    {
        $postsMetaRecords = $this->getAll($postMetaFieldKeys, $postType, $postStatus)->toArray();
        return $this->baseFactory->collection($this->filterByUniqueIdWhenPresent($postsMetaRecords, $uniqueId, $uniqueColumn));
    }

    /**
     * @param array $postsMetaRecords
     * @param int $uniqueId
     * @param string $uniqueColumn
     * @return array
     */
    private function filterByUniqueIdWhenPresent(array $postsMetaRecords, int $uniqueId, string $uniqueColumn): array
    {
        $filteredPostsMetaRecords = [];
        foreach ($postsMetaRecords as $row) {
            if (isset($row[$uniqueColumn]) && (int)$row[$uniqueColumn] !== $uniqueId) {
                continue;
            }
            $filteredPostsMetaRecords[] = $row;
        }
        return $filteredPostsMetaRecords;
    }
}
