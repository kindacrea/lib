<?php
namespace Kcpck\App\Tests;

use Kcpck\App\Tests\Mock\Entity as MockEntity;
use PHPUnit\Framework\TestCase;

class BaseTestcase extends TestCase
{
    /**
     * @return array[]
     */
    protected function getStaticRecordsSortedAsc(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Record A'
            ],
            [
                'id' => 2,
                'name' => 'Record B'
            ],
            [
                'id' => 3,
                'name' => 'Record C'
            ]
        ];
    }

    /**
     * @return array[]
     */
    protected function getStaticRecordsWithDuplicateId(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Record A'
            ],
            [
                'id' => 2,
                'name' => 'Record B'
            ],
            [
                'id' => 1,
                'name' => 'Record C'
            ]
        ];
    }

    /**
     * @return array[]
     */
    protected function getStaticRecordsWithNamedIndexesSortedAsc(): array
    {
        return [
            'one' => [
                'id' => 1,
                'name' => 'Record A'
            ],
            'two' => [
                'id' => 2,
                'name' => 'Record B'
            ],
            'three' => [
                'id' => 3,
                'name' => 'Record C'
            ]
        ];
    }

    /**
     * @return array[]
     */
    protected function getStaticRecordsSortedDesc(): array
    {
        return [
            [
                'id' => 3,
                'name' => 'Record C'
            ],
            [
                'id' => 2,
                'name' => 'Record B'
            ],
            [
                'id' => 1,
                'name' => 'Record A'
            ]
        ];
    }

    /**
     * @return array[]
     */
    protected function getStaticRecordsSortedRandomly(): array
    {
        return [
            [
                'id' => 3,
                'name' => 'Record C'
            ],
            [
                'id' => 1,
                'name' => 'Record A'
            ],
            [
                'id' => 2,
                'name' => 'Record B'
            ]
        ];
    }

    /**
     * @return MockEntity[]
     */
    protected function getStaticMockRecordsSortedAsc(): array
    {
        return [
            new MockEntity([
                'id' => 1,
                'name' => 'Record A'
            ]),
            new MockEntity([
                'id' => 2,
                'name' => 'Record B'
            ]),
            new MockEntity([
                'id' => 3,
                'name' => 'Record C'
            ])
        ];
    }

    /**
     * @return MockEntity[]
     */
    protected function getStaticMockRecordsSortedRandomly(): array
    {
        return [
            new MockEntity([
                'id' => 3,
                'name' => 'Record C'
            ]),
            new MockEntity([
                'id' => 1,
                'name' => 'Record A'
            ]),
            new MockEntity([
                'id' => 2,
                'name' => 'Record B'
            ])
        ];
    }
}
