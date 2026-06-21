<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\Tests\Stub\StubIdentity;
use Libelula\CommonHelpers\Utils;
use MongoDB\BSON\UTCDateTime;
use Yii;

class UtilsTest extends TestCase
{
    private const DATE_RE = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

    public function testGetNowReturnsFormattedDate(): void
    {
        $this->assertMatchesRegularExpression(self::DATE_RE, Utils::getNow());
    }

    public function testGetNowTimeReturnsTimestamp(): void
    {
        $this->assertIsInt(Utils::getNowTime());
    }

    public function testGetDate(): void
    {
        // 2020-06-15 12:00:00 UTC
        $time = strtotime('2020-06-15 12:00:00');
        $this->assertSame('2020-06-15 12:00:00', Utils::getDate($time));
    }

    public function testGetNowMenosDias(): void
    {
        $this->assertMatchesRegularExpression(self::DATE_RE, Utils::getNowMenosDias(3));
    }

    public function testGetDosDecimales(): void
    {
        $this->assertSame('2.50', Utils::getDosDecimales(2.5));
        $this->assertSame('2.56', Utils::getDosDecimales(2.555));
    }

    public function testGetMinutesTranscurridos(): void
    {
        $tenMinutesAgo = strtotime(Utils::getNow()) - 600;
        $this->assertEqualsWithDelta(10, Utils::getMinutesTranscurridos($tenMinutesAgo), 1);
    }

    public function testGetMongoDateReturnsUTCDateTime(): void
    {
        $this->assertInstanceOf(UTCDateTime::class, Utils::getMongoDate('2020-01-01 00:00:00'));
    }

    public function testGetNowMongoReturnsUTCDateTime(): void
    {
        $this->assertInstanceOf(UTCDateTime::class, Utils::getNowMongo());
    }

    public function testGetMongoDateFromTime(): void
    {
        $this->assertInstanceOf(UTCDateTime::class, Utils::getMongoDateFromTime(time()));
    }

    public function testGetDateFromMongoRoundTrip(): void
    {
        $ms = strtotime('2020-06-15 12:00:00') * 1000;
        $date = new UTCDateTime($ms);
        $this->assertSame('2020-06-15 12:00:00', Utils::getDateFromMongo($date));
    }

    public function testGetDateFromMongoNullReturnsEmptyString(): void
    {
        $this->assertSame('', Utils::getDateFromMongo(null));
    }

    public function testGetUserIP(): void
    {
        $this->mockWebApplication();
        $_SERVER['REMOTE_ADDR'] = '203.0.113.7';
        $this->assertSame('203.0.113.7', Utils::getUserIP());
    }

    public function testGetIDActualUser(): void
    {
        $this->mockWebApplication();
        Yii::$app->user->setIdentity(new StubIdentity('user-123'));
        $this->assertSame('user-123', Utils::getIDActualUser());
    }
}
