<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\ValueHelpers;
use PHPUnit\Framework\TestCase;

class ValueHelpersTest extends TestCase
{
    public function testToDotDecimals(): void
    {
        $this->assertSame('1234.50', ValueHelpers::toDotDecimals(1234.5));
        $this->assertSame('1,234.50', ValueHelpers::toDotDecimals(1234.5, 2, ','));
        $this->assertSame('5.000', ValueHelpers::toDotDecimals(5, 3));
    }

    public function testToCommaDecimals(): void
    {
        $this->assertSame('1234,50', ValueHelpers::toCommaDecimals(1234.5));
        $this->assertSame('7,5', ValueHelpers::toCommaDecimals(7.5, 1));
    }

    public function testNumberFormatUsesDotByDefault(): void
    {
        $this->assertSame('5.50', ValueHelpers::numberFormat(5.5));
        $this->assertSame('1234.50', ValueHelpers::numberFormat(1234.5));
    }

    public function testNumberFormatCheckDecimals(): void
    {
        // Integer value with checkDecimals drops the decimals.
        $this->assertSame('100', ValueHelpers::numberFormat(100, 2, '.', true));
        // Decimal value keeps them.
        $this->assertSame('100.10', ValueHelpers::numberFormat(100.1, 2, '.', true));
    }

    public function testRound(): void
    {
        $this->assertSame(2.57, ValueHelpers::round(2.5678));
        $this->assertSame(2.6, ValueHelpers::round(2.5678, 1));
    }

    public function testFloorFormat(): void
    {
        $this->assertSame('2.00', ValueHelpers::floorFormat(2.9));
    }

    public function testFloatFormat(): void
    {
        $this->assertSame('2.50', ValueHelpers::floatFormat(2.5));
        // checkDecimals on an integer value drops decimals.
        $this->assertSame('3', ValueHelpers::floatFormat(3.0, true));
    }

    public function testIsDecimal(): void
    {
        $this->assertTrue(ValueHelpers::isDecimal(2.5));
        $this->assertFalse(ValueHelpers::isDecimal(2));
        $this->assertFalse(ValueHelpers::isDecimal('not-a-number'));
    }

    public function testStringToFloat(): void
    {
        $this->assertSame(1000.01, ValueHelpers::stringToFloat('1,000.01'));
        $this->assertSame(-50.0, ValueHelpers::stringToFloat('$ -50'));
    }

    public function testIsBeforeZero(): void
    {
        $this->assertTrue(ValueHelpers::isBeforeZero('0123'));
        $this->assertFalse(ValueHelpers::isBeforeZero('123'));
        $this->assertFalse(ValueHelpers::isBeforeZero('0'));
        $this->assertFalse(ValueHelpers::isBeforeZero(''));
        $this->assertFalse(ValueHelpers::isBeforeZero('0.5'));
    }
}
