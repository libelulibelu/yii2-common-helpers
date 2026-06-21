<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\RegexHelpers;
use PHPUnit\Framework\TestCase;

class RegexHelpersTest extends TestCase
{
    public function testContainsLetters(): void
    {
        $this->assertTrue(RegexHelpers::containsLetters('abc123'));
        $this->assertTrue(RegexHelpers::containsLetters('hello'));
    }

    public function testDoesNotContainLetters(): void
    {
        $this->assertFalse(RegexHelpers::containsLetters('12345'));
        $this->assertFalse(RegexHelpers::containsLetters('!@#$%'));
    }
}
