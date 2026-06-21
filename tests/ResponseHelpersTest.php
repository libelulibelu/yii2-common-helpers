<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\ResponseHelpers;
use Yii;
use yii\web\Response;

class ResponseHelpersTest extends TestCase
{
    public function testMergeMessageResponse(): void
    {
        $this->assertSame([
            'transaccion' => true,
            'mensaje' => 'hi',
            'x' => 1,
        ], ResponseHelpers::mergeMessageResponse('hi', ['x' => 1]));
    }

    public function testMergeBasicError(): void
    {
        $this->assertSame([
            'transaccion' => false,
            'errorDescripcion' => 'boom',
            'code' => 42,
        ], ResponseHelpers::mergeBasicError('boom', ['code' => 42]));
    }

    public function testDataResponse(): void
    {
        $this->assertSame([
            'transaccion' => true,
            'data' => [1, 2, 3],
        ], ResponseHelpers::dataResponse([1, 2, 3]));
    }

    public function testMessageResponse(): void
    {
        $this->assertSame([
            'transaccion' => true,
            'mensaje' => 'ok',
        ], ResponseHelpers::messageResponse('ok'));
    }

    public function testMergeResponse(): void
    {
        $this->assertSame([
            'transaccion' => true,
            'a' => 1,
        ], ResponseHelpers::mergeResponse(['a' => 1]));
    }

    public function testToAPIResponseSetsJsonFormat(): void
    {
        $this->mockWebApplication();
        ResponseHelpers::toAPIResponse();

        $this->assertSame(Response::FORMAT_JSON, Yii::$app->response->format);
        $this->assertTrue(ResponseHelpers::isJSON());
    }

    public function testToHTMLResponseSetsHtmlFormat(): void
    {
        $this->mockWebApplication();
        ResponseHelpers::toHTMLResponse();

        $this->assertSame(Response::FORMAT_HTML, Yii::$app->response->format);
    }
}
