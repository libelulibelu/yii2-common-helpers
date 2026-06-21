<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\RequestHelpers;
use Libelula\CommonHelpers\Tests\Stub\StubRequest;
use Yii;
use yii\web\HttpException;

class RequestHelpersTest extends TestCase
{
    private array $ipKeys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
    ];

    protected function tearDown(): void
    {
        foreach ($this->ipKeys as $key) {
            unset($_SERVER[$key]);
        }
        parent::tearDown();
    }

    public function testGetUserIPReturnsPublicIp(): void
    {
        $_SERVER['REMOTE_ADDR'] = '8.8.8.8';
        $this->assertSame('8.8.8.8', RequestHelpers::getUserIP());
    }

    public function testGetUserIPSkipsPrivateRanges(): void
    {
        $_SERVER['REMOTE_ADDR'] = '192.168.1.10';
        $this->assertNull(RequestHelpers::getUserIP());
    }

    public function testLongRequestRaisesMemoryLimit(): void
    {
        RequestHelpers::longRequest();
        $this->assertSame('2048M', ini_get('memory_limit'));
    }

    public function testGetPostDataFromBodyParams(): void
    {
        $this->mockWebApplication();
        $this->request()->stubBodyParams = ['a' => 1];

        $this->assertSame(['a' => 1], RequestHelpers::getPostData());
    }

    public function testGetPostDataFallsBackToRawBody(): void
    {
        $this->mockWebApplication();
        $this->request()->stubBodyParams = [];
        $this->request()->stubRawBody = '{"b":2}';

        $this->assertSame(['b' => 2], RequestHelpers::getPostData());
    }

    public function testGetPostDataOrFailThrowsWhenEmpty(): void
    {
        $this->mockWebApplication();
        $this->expectException(HttpException::class);
        RequestHelpers::getPostDataOrFail();
    }

    public function testGetPostDataAsObject(): void
    {
        $this->mockWebApplication();
        $this->request()->stubBodyParams = ['x' => 5];

        $object = RequestHelpers::getPostDataAsObject();
        $this->assertInstanceOf(\stdClass::class, $object);
        $this->assertSame(5, $object->x);
    }

    public function testGetPostDataAsObjectReturnsEmptyObjectWhenNoData(): void
    {
        $this->mockWebApplication();
        $this->assertEquals(new \stdClass(), RequestHelpers::getPostDataAsObject());
    }

    public function testGetRawAndGetRawPost(): void
    {
        $this->mockWebApplication();
        $this->request()->stubRawBody = '{"k":1}';

        $this->assertSame('{"k":1}', RequestHelpers::getRaw());
        $this->assertSame(['k' => 1], RequestHelpers::getRawPost(true));
    }

    private function request(): StubRequest
    {
        return Yii::$app->request;
    }
}
