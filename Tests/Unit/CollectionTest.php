<?php
namespace Kcpck\Unit;

require __DIR__ . '/../../../../autoload.php';

use Kcpck\App\Exception\EmptyCollectionException;
use Kcpck\App\Factory;
use Kcpck\App\Collection\Collection;
use Kcpck\App\Entity\Interfaces\Entity as EntityInterface;
use Kcpck\App\Tests\BaseTestcase;
use Kcpck\App\Tests\Mock\Entity;

class CollectionTest extends BaseTestcase
{
    /**
     * @test
     * @return void
     */
    public function canMakeCollection(): void
    {
        $records = [
            [
                'id' => 1,
                'name' => 'Record 1'
            ],
            [
                'id' => 2,
                'name' => 'Record 2'
            ]
        ];

        $collection = factory::make()->collection($records);
        self::assertCount(2, $collection);
    }

    /**
     * @test
     * @return void
     */
    public function canSetItems(): void
    {
        $records = [
            [
                'id' => 1,
                'name' => 'Record 1'
            ],
            [
                'id' => 2,
                'name' => 'Record 2'
            ]
        ];

        $collection = factory::make()->collection($records);

        $records_to_set = [
            [
                'id' => 3,
                'name' => 'Record 3'
            ]
        ];
        $collection->set($records_to_set);

        self::assertSame($records_to_set, $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortAscMock(): void
    {
        $collection = factory::make()->collection($this->getStaticMockRecordsSortedRandomly());
        $collection->sortAsc(function (EntityInterface $entity) {
            return $entity->getId();
        });
        $this->assertSame($this->getStaticRecordsSortedAsc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortDescMock(): void
    {
        $collection = factory::make()->collection($this->getStaticMockRecordsSortedRandomly());
        $collection->sortDesc(function (EntityInterface $entity) {
            return $entity->getId();
        });
        self::assertSame($this->getStaticRecordsSortedDesc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortAsc(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsSortedRandomly());
        $collection->sortAsc(function (array $entity) {
            return $entity['id'];
        });
        $this->assertSame($this->getStaticRecordsSortedAsc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortDesc(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsSortedRandomly());
        $collection->sortDesc(function (array $entity) {
            return $entity['id'];
        });
        self::assertSame($this->getStaticRecordsSortedDesc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortAscValues(): void
    {
        $collection = factory::make()->collection([3, 1, 2]);
        $collection->sortAsc(function (int $entity) {
            return $entity;
        });
        $this->assertSame([1, 2, 3], $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canSortDescValues(): void
    {
        $collection = factory::make()->collection([3, 1, 2]);
        $collection->sortDesc(function (int $entity) {
            return $entity;
        });
        self::assertSame([3, 2, 1], $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canConvertToArrayFromRecords(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsSortedAsc());
        self::assertSame($this->getStaticRecordsSortedAsc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canConvertToArrayFromRecordsWithNamedIndexes(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsWithNamedIndexesSortedAsc());
        self::assertSame($this->getStaticRecordsWithNamedIndexesSortedAsc(), $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function can_pluck_from_indexed_array(): void
    {
        $names = [
            'Record A', 'Record B', 'Record C'
        ];

        $collection = factory::make()->collection($names);
        $matching_names = $collection->pluck(function (string $value) {
            return $value;
        });

        self::assertSame($names, $matching_names->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canPluckFromRecords(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsSortedAsc());
        $names = $collection->pluck(function (array $row) {
            return $row['name'];
        });

        $expected_names = [
            'Record A', 'Record B', 'Record C'
        ];

        self::assertSame($names->toArray(), $expected_names);
    }

    /**
     * @test
     * @return void
     */
    public function canPluckFromRecordsWithNamedIndexes(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsWithNamedIndexesSortedAsc());
        $names = $collection->pluck(function (array $row) {
            return $row['name'];
        });

        $expected_names = [
            'Record A', 'Record B', 'Record C'
        ];

        self::assertSame($names->toArray(), $expected_names);
    }

    /**
     * @test
     * @return void
     */
    public function canCount(): void
    {
        $collection = factory::make()->collection($this->getStaticRecordsSortedAsc());
        self::assertSame($collection->count(), 3);
    }

    /**
     * @test
     * @return void
     */
    public function canGetFirstFromRecords(): void
    {
        $static_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        self::assertSame($static_records_sorted_asc[0], $collection->first());
    }

    public function test_throws_exception_if_no_first_record_in_collection(): void
    {
        $this->expectException(EmptyCollectionException::class);
        factory::make()->collection()->first();
    }

    public function testCanGetLastFromRecords(): void
    {
        $records = $this->getStaticRecordsSortedAsc();
        $collection = new Collection($records);

        self::assertSame($records[2], $collection->last());
    }

    public function testThrowsEexceptionIfNoLastRecordInCollection(): void
    {
        $this->expectException(EmptyCollectionException::class);
        factory::make()->collection()->last();
    }

    /**
     * @test
     * @return void
     */
    public function canGetFirstFromRecordsWithNamedIndexes(): void
    {
        $static_records_sorted_asc = $this->getStaticRecordsWithNamedIndexesSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        self::assertSame($static_records_sorted_asc['one'], $collection->first());
    }

    /**
     * @test
     * @return void
     */
    public function canGetLastFromRecordsWithNamedIndexes(): void
    {
        $records = $this->getStaticRecordsWithNamedIndexesSortedAsc();
        $collection = new Collection($records);
        self::assertSame($records['three'], $collection->last());
    }

    /**
     * @test
     * @return void
     */
    public function canSlice(): void
    {
        $static_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        $collection->slice(1, 2);

        self::assertSame([
            $static_records_sorted_asc[1], $static_records_sorted_asc[2],
        ], $collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canCheckIfEmpty(): void
    {
        $collection = factory::make()->collection([]);
        self::assertTrue($collection->empty());

        $static_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);
        self::assertFalse($collection->empty());
    }

    /**
     * @test
     * @return void
     */
    public function canFilterFromRecords(): void
    {
        $static_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        $filtered_collection = $collection->filter(function (array $row) {
            return $row['name'] === 'Record A' || $row['name'] === 'Record C';
        });

        self::assertSame([
            0 => $static_records_sorted_asc[0],
            2 => $static_records_sorted_asc[2],
        ], $filtered_collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canFilterFromRecordsWithNamedIndexes(): void
    {
        $static_records_sorted_asc = $this->getStaticRecordsWithNamedIndexesSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        $filtered_collection = $collection->filter(function (array $row) {
            return $row['name'] === 'Record A' || $row['name'] === 'Record C';
        });

        self::assertSame([
            'one' => $static_records_sorted_asc['one'],
            'three' => $static_records_sorted_asc['three'],
        ], $filtered_collection->toArray());
    }

    /**
     * @test
     */
    public function canConvertCollectionWithEntitiesToList(): void
    {
        $static_mock_records_sorted_asc = $this->getStaticMockRecordsSortedAsc();
        $collection = new Collection($static_mock_records_sorted_asc);

        $list = $collection->toList(
            function (EntityInterface $item) {
                return $item->getId();
            },
            function ($item) {
                return $item->getName();
            }
        );

        $expected_list = [
            1 => 'Record A',
            2 => 'Record B',
            3 => 'Record C'
        ];

        self::assertSame($expected_list, $list->toArray());
    }

    /**
     * @test
     */
    public function canConvertCollectionWithArraysToList(): void
    {
        $static_mock_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = new Collection($static_mock_records_sorted_asc);

        $list = $collection->toList(
            function (array $item) {
                return $item['id'];
            },
            function ($item) {
                return $item['name'];
            }
        );

        $expected_list = [
            1 => 'Record A',
            2 => 'Record B',
            3 => 'Record C'
        ];

        self::assertSame($expected_list, $list->toArray());
    }

    /**
     * @test
     */
    public function canConvertCollectionWithDuplicateIdToMultilevelArray(): void
    {
        $static_mock_records_sorted_asc = $this->getStaticRecordsWithDuplicateId();
        $collection = new Collection($static_mock_records_sorted_asc);

        $list = $collection->toList(
            function (array $item) {
                return $item['id'];
            },
            function ($item) {
                return $item['name'];
            }, true
        );

        $expected_list = [
            1 => [
                0 => 'Record A',
                1 => 'Record C'
            ],
            2 => [
                0 => 'Record B'
            ]
        ];

        self::assertSame($expected_list, $list->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canMapFromRecords(): void
    {
        $text_to_append = ' (modified)';

        $static_records_sorted_asc = $this->getStaticRecordsSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        $changed_collection = $collection->map(function (array $row) use ($text_to_append) {
            $row['name'] .= $text_to_append;
            return $row;
        });

        $static_records_sorted_asc[0]['name'] .= $text_to_append;
        $static_records_sorted_asc[1]['name'] .= $text_to_append;
        $static_records_sorted_asc[2]['name'] .= $text_to_append;

        self::assertEquals($static_records_sorted_asc, $changed_collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canMapFromRecordsWithNamedIndexes(): void
    {
        $text_to_append = ' (modified)';

        $static_records_sorted_asc = $this->getStaticRecordsWithNamedIndexesSortedAsc();
        $collection = factory::make()->collection($static_records_sorted_asc);

        $changed_collection = $collection->map(function (array $row) use ($text_to_append) {
            $row['name'] .= $text_to_append;
            return $row;
        });

        $static_records_sorted_asc['one']['name'] .= $text_to_append;
        $static_records_sorted_asc['two']['name'] .= $text_to_append;
        $static_records_sorted_asc['three']['name'] .= $text_to_append;

        self::assertEquals($static_records_sorted_asc, $changed_collection->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function canImplode(): void
    {
        $items = ['A', 'B', 'C'];
        $collection = factory::make()->collection($items);
        self::assertSame('A, B, C', $collection->implode(', '));
    }

    /**
     * @test
     * @return void
     */
    public function canReturnIndexArrayFromNamedArray(): void
    {
        $name = 'Test';
        $version = '123';

        $array = [
            'name' => $name,
            'version' => $version,
        ];

        $collection = new Collection($array);
        $indexed = $collection->toArray(true);

        self::assertSame($indexed[0], $name);
        self::assertSame($indexed[1], $version);
    }

    /**
     * @test
     * @return void
     */
    public function canUsePropertiesViaArrayAccess(): void
    {
        $collection = new Collection([
            'name' => 'Test',
            'version' => '123',
        ]);

        self::assertSame('Test', $collection['name']);
        self::assertSame('123', $collection['version']);
    }

    /**
     * @test
     * @return void
     */
    public function isIterable(): void
    {
        $collection1 = new Collection(['Test 1', 'Test 2', 'Test 3']);
        $runs1 = 0;
        foreach ($collection1 as $i1 => $item1) {
            self::assertSame($i1, $runs1++);
        }

        $runs2 = ['one' => 'Test 1', 'two' => 'Test 2', 'three' => 'Test 3'];
        $collection2 = new Collection($runs2);
        foreach ($collection2 as $i2 => $item2) {
            self::assertSame($runs2[$i2], $item2);
        }

        self::assertIsIterable($collection1);
        self::assertIsIterable($collection2);
    }

    public function testCollectionCanShuffleItems(): void
    {
        $collection = new Collection([
            new entity(['name' => 'Item 1']),
            new entity(['name' => 'Item 2']),
            new entity(['name' => 'Item 3']),
            new entity(['name' => 'Item 4']),
        ]);

        $match = 0;
        $matches = [];
        for ($i = 0; $i <= 5; $i++) {
            $items = $collection->shuffle();

            if ( // First time no match
                !empty($matches) &&
                $matches['first'] === $items->byKey(0)->name &&
                $matches['second'] === $items->byKey(1)->name &&
                $matches['third'] === $items->byKey(2)->name
            ) {
                $match++;
            }

            $matches['first'] = $items->byKey(0)->name;
            $matches['second'] = $items->byKey(1)->name;
            $matches['third'] = $items->byKey(2)->name;
        }

        self::assertLessThan(5, $match);
    }

    public function testFindingASpecificItemValueUsingFindMethod(): void
    {
        $collection = new Collection([
            'Item 1', 'Item 2', 'Item 3', 'Item 4'
        ]);

        self::assertSame('Item 3', $collection->find('Item 3')->first());
    }

    public function testFindingASpecificItemArrayUsingFindMethod(): void
    {
        $collection = new Collection([
            ['name' => 'Item 1'],
            ['name' => 'Item 2'],
            ['name' => 'Item 3'],
            ['name' => 'Item 4'],
        ]);

        self::assertSame('Item 3', $collection->find('Item 3', 'name')->first()['name']);
    }

    public function testFindingASpecificItemInstanceUsingFindMethod(): void
    {
        $collection = new Collection([
            new entity(['name' => 'Item 1']),
            new entity(['name' => 'Item 2']),
            new entity(['name' => 'Item 3']),
            new entity(['name' => 'Item 4']),
        ]);

        self::assertSame('Item 3', $collection->find('Item 3', 'name')->first()->name);
    }

    public function testCanAppendValueToCollection(): void
    {
        $collection = new Collection([
            'Item 1',
            'Item 2',
        ]);
        $collection->append('Item 3');

        self::assertSame('Item 1', $collection->byKey(0));
        self::assertSame('Item 2', $collection->byKey(1));
        self::assertSame('Item 3', $collection->byKey(2));
    }

    public function testCanAppendArrayToCollection(): void
    {
        $collection = new Collection([
            ['name' => 'Item 1'],
            ['name' => 'Item 2'],
        ]);

        $collection->append(['name' => 'Item 3']);

        self::assertSame('Item 1', $collection->byKey(0)['name']);
        self::assertSame('Item 2', $collection->byKey(1)['name']);
        self::assertSame('Item 3', $collection->byKey(2)['name']);
    }

    public function testCanAppendInstanceToCollection(): void
    {
        $collection = new Collection([
            new entity(['name' => 'Item 1']),
            new entity(['name' => 'Item 2']),
        ]);

        $collection->append(new entity(['name' => 'Item 3']));

        self::assertSame('Item 1', $collection->byKey(0)->name);
        self::assertSame('Item 2', $collection->byKey(1)->name);
        self::assertSame('Item 3', $collection->byKey(2)->name);
    }

    public function testCanPrependValueToCollection(): void
    {
        $collection = new Collection([
            'Item 2',
            'Item 3',
        ]);
        $collection->prepend('Item 1');

        self::assertSame('Item 1', $collection->byKey(0));
        self::assertSame('Item 2', $collection->byKey(1));
        self::assertSame('Item 3', $collection->byKey(2));
    }

    public function testCanPrependArrayToCollection(): void
    {
        $collection = new Collection([
            ['name' => 'Item 2'],
            ['name' => 'Item 3'],
        ]);

        $collection->prepend(['name' => 'Item 1']);

        self::assertSame('Item 1', $collection->byKey(0)['name']);
        self::assertSame('Item 2', $collection->byKey(1)['name']);
        self::assertSame('Item 3', $collection->byKey(2)['name']);
    }

    public function testCanPrependInstanceToCollection(): void
    {
        $collection = new Collection([
            new entity(['name' => 'Item 2']),
            new entity(['name' => 'Item 3']),
        ]);

        $collection->prepend(new entity(['name' => 'Item 1']));

        self::assertSame('Item 1', $collection->byKey(0)->name);
        self::assertSame('Item 2', $collection->byKey(1)->name);
        self::assertSame('Item 3', $collection->byKey(2)->name);
    }

    public function testCanMergeTwoCollections(): void
    {
        $collection1 = new Collection([
            new entity(['name' => 'Item 1']),
            new entity(['name' => 'Item 2']),
        ]);

        $collection2 = new Collection([
            new entity(['name' => 'Item 3']),
            new entity(['name' => 'Item 4']),
        ]);

        $collection1->merge($collection2);

        self::assertSame('Item 1', $collection1->byKey(0)->name);
        self::assertSame('Item 2', $collection1->byKey(1)->name);
        self::assertSame('Item 3', $collection1->byKey(2)->name);
        self::assertSame('Item 4', $collection1->byKey(3)->name);
    }

    public function testCanDetermineIfASpecificFieldContainsASpecificValue(): void
    {
        $collection1 = new Collection(['asd', 'dsa', 'qwe', 'ewq']);

        self::assertTrue($collection1->contains(function (string $item) {
            return $item;
        }, 'dsa'));

        self::assertFalse($collection1->contains(function (string $item) {
            return $item;
        }, 'mnb'));

        $collection2 = new Collection([
            ['id' => 1, 'name' => 'qwe', 'title' => 'ewq'],
            ['id' => 2, 'name' => 'uio', 'title' => 'oiu'],
            ['id' => 3, 'name' => 'gfd', 'title' => 'dfg'],
        ]);

        self::assertTrue($collection2->contains(function (array $item) {
            return $item['name'];
        }, 'uio'));

        self::assertFalse($collection2->contains(function (array $item) {
            return $item['name'];
        }, 'mnb'));

        $collection3 = new Collection([
            (object)['id' => 1, 'name' => 'qwe', 'title' => 'ewq'],
            (object)['id' => 2, 'name' => 'uio', 'title' => 'oiu'],
            (object)['id' => 3, 'name' => 'gfd', 'title' => 'dfg'],
        ]);

        self::assertTrue($collection3->contains(function (object $item) {
            return $item->name;
        }, 'uio'));

        self::assertFalse($collection3->contains(function (object $item) {
            return $item->name;
        }, 'mnb'));
    }
}
