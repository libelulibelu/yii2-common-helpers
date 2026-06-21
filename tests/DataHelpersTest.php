<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\DataHelpers;
use PHPUnit\Framework\TestCase;

class DataHelpersTest extends TestCase
{
    public function testToArray(): void
    {
        $obj = (object) ['a' => 1, 'b' => 2];
        $this->assertSame(['a' => 1, 'b' => 2], DataHelpers::toArray($obj));
    }

    public function testToObject(): void
    {
        $obj = DataHelpers::toObject(['a' => 1]);
        $this->assertInstanceOf(\stdClass::class, $obj);
        $this->assertSame(1, $obj->a);
    }

    public function testArrayGroupBy(): void
    {
        $list = [
            ['type' => 'x', 'v' => 1],
            ['type' => 'x', 'v' => 2],
            ['type' => 'y', 'v' => 3],
        ];
        $grouped = DataHelpers::arrayGroupBy($list, 'type');

        $this->assertCount(2, $grouped['x']);
        $this->assertCount(1, $grouped['y']);
    }

    public function testObjectGroupBy(): void
    {
        $list = [
            (object) ['type' => 'x'],
            (object) ['type' => 'y'],
            (object) ['type' => 'x'],
        ];
        $grouped = DataHelpers::objectGroupBy($list, 'type');

        $this->assertCount(2, $grouped['x']);
        $this->assertCount(1, $grouped['y']);
    }

    public function testArrayToHashMap(): void
    {
        $list = [
            ['id' => 'a', 'v' => 1],
            ['id' => 'b', 'v' => 2],
        ];
        $map = DataHelpers::arrayToHashMap($list, 'id');

        $this->assertSame(1, $map['a']['v']);
        $this->assertSame(2, $map['b']['v']);
    }

    public function testObjectToHashMap(): void
    {
        $list = [
            (object) ['id' => 'a'],
            (object) ['id' => 'b'],
        ];
        $map = DataHelpers::objectToHashMap($list, 'id');

        $this->assertSame('a', $map['a']->id);
        $this->assertSame('b', $map['b']->id);
    }

    public function testIsValidAttribute(): void
    {
        $this->assertTrue(DataHelpers::isValidAttribute('foo'));
        $this->assertFalse(DataHelpers::isValidAttribute('foo-bar'));
        $this->assertFalse(DataHelpers::isValidAttribute(123));
    }

    public function testSplitList(): void
    {
        $this->assertSame([[1, 2], [3, 4]], DataHelpers::splitList([1, 2, 3, 4]));
    }

    public function testToArrayFlat(): void
    {
        $matriz = [['a' => 1], ['b' => 2]];
        $this->assertSame(['a' => 1, 'b' => 2], DataHelpers::toArrayFlat($matriz));
        $this->assertSame([1, 2], DataHelpers::toArrayFlat($matriz, false));
    }

    public function testToArrayFlatRecursive(): void
    {
        $matriz = [[1, [2, 3]], [4]];
        $this->assertSame([1, 2, 3, 4], DataHelpers::toArrayFlatRecursive($matriz, false));
    }

    public function testShuffleAssocKeepsKeyset(): void
    {
        $list = ['a' => 1, 'b' => 2, 'c' => 3];
        $shuffled = DataHelpers::shuffleAssoc($list);

        $this->assertSame($list, $this->ksorted($shuffled));
    }

    public function testSortByList(): void
    {
        $list = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];
        $sorted = DataHelpers::sortByList($list, 'id', [3, 1, 2]);

        $this->assertSame([['id' => 3], ['id' => 1], ['id' => 2]], $sorted);
    }

    private function ksorted(array $array): array
    {
        ksort($array);
        return $array;
    }
}
