<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\MapperHelpers;
use PHPUnit\Framework\TestCase;

class MapperHelpersTest extends TestCase
{
    public function testHashRemovePrefix(): void
    {
        $result = MapperHelpers::hashRemovePrefix('get', ['getName', 'getAge']);

        $this->assertSame([
            'name' => 'getName',
            'age' => 'getAge',
        ], $result);
    }

    public function testHashMatrizFlattensNestedKeys(): void
    {
        $data = [
            'val' => 1,
            'sub' => [
                'internal' => 'dos',
            ],
        ];

        $this->assertSame([
            'val' => 1,
            'sub.internal' => 'dos',
        ], MapperHelpers::hashMatriz($data));
    }
}
