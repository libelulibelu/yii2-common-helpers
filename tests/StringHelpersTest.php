<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\StringHelpers;
use PHPUnit\Framework\TestCase;

class StringHelpersTest extends TestCase
{
    public function testRepeat(): void
    {
        $this->assertSame('ababab', StringHelpers::repeat('ab', 3));
        $this->assertSame('', StringHelpers::repeat('ab', 0));
    }

    public function testRepeatWithNegativeMultipleReturnsEmpty(): void
    {
        $this->assertSame('', StringHelpers::repeat('x', -5));
    }

    public function testContains(): void
    {
        $this->assertTrue(StringHelpers::contains('hello world', 'world'));
        $this->assertFalse(StringHelpers::contains('hello world', 'xyz'));
    }
}
