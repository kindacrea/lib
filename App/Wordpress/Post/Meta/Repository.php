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
     * @param string $orderBy
     * @param string $orderDir
     * @return Collection
     */
    public function getAll(array $postMetaFieldKeys, string $postType = 'post', string $postStatus = 'publish',
                           ?int $postId = null, string $orderBy = 'pm.post_id', string $orderDir = 'ASC'): Collection
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
        $sql .= ' ORDER BY ' . $orderBy . ' ' . $orderDir;
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
     * @param string $uniqueId
     * @param string $uniqueColumn
     * @param array $postMetaFieldKeys
     * @param string $postType
     * @param string $postStatus
     * @return Collection
     */
    public function getAllByMetaIdentifier(string $uniqueId, string $uniqueColumn, array $postMetaFieldKeys,
                                           string $postType = 'post', string $postStatus = 'publish'): Collection
    {
        $postMetaFieldKeys = $this->addRequiredUniqueColumnToPostMetaFieldKeys($uniqueColumn, $postMetaFieldKeys);
        $postsMetaRecords = $this->getAll($postMetaFieldKeys, $postType, $postStatus)->toArray();
        return $this->baseFactory->collection($this->filterByUniqueIdWhenPresent($postsMetaRecords, $uniqueId, $uniqueColumn));
    }

    /**
     * @param array $postsMetaRecords
     * @param string $uniqueId
     * @param string $uniqueColumn
     * @return array
     */
    private function filterByUniqueIdWhenPresent(array $postsMetaRecords, string $uniqueId, string $uniqueColumn): array
    {
        $filteredPostsMetaRecords = [];
        foreach ($postsMetaRecords as $row) {
            if (isset($row[$uniqueColumn]) &&
                mb_strtolower((string)$row[$uniqueColumn], 'UTF-8') !== mb_strtolower($uniqueId, 'UTF-8')) {
                continue;
            }
            $filteredPostsMetaRecords[] = $row;
        }
        return $filteredPostsMetaRecords;
    }

    /**
     * @param string $uniqueColumn
     * @param array $postMetaFieldKeys
     * @return array
     */
    public function addRequiredUniqueColumnToPostMetaFieldKeys(string $uniqueColumn, array $postMetaFieldKeys): array
    {
        if (!in_array($uniqueColumn, $postMetaFieldKeys, true)) {
            array_unshift($postMetaFieldKeys, $uniqueColumn);
        }
        return $postMetaFieldKeys;
    }
}
