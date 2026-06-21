<?php

namespace Libelula\CommonHelpers\Tests;

use Libelula\CommonHelpers\Tests\Stub\StubIdentity;
use Libelula\CommonHelpers\Tests\Stub\StubRequest;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Base test case. Provides a minimal Yii web application for the helpers that
 * read from Yii::$app (RequestHelpers, ResponseHelpers, Utils user methods).
 */
abstract class TestCase extends BaseTestCase
{
    protected function tearDown(): void
    {
        $this->destroyApplication();
        parent::tearDown();
    }

    /**
     * Spin up a fresh yii\web\Application. Pass overrides to merge into the config
     * (e.g. a configured `request` stub or `user` identity).
     */
    protected function mockWebApplication(array $config = []): Application
    {
        return new Application(ArrayHelper::merge([
            'id' => 'test-app',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'components' => [
                'request' => [
                    'class' => StubRequest::class,
                    'cookieValidationKey' => 'test-key',
                    'scriptFile' => __DIR__ . '/index.php',
                    'scriptUrl' => '/index.php',
                ],
                'response' => [
                    'class' => \yii\web\Response::class,
                ],
                'user' => [
                    'class' => \yii\web\User::class,
                    'identityClass' => StubIdentity::class,
                    'enableSession' => false,
                ],
            ],
        ], $config));
    }

    protected function destroyApplication(): void
    {
        if (Yii::$app !== null) {
            // Yii registers global error/exception handlers on bootstrap;
            // unregister() restores the previous (PHPUnit's) handlers so the
            // test is not flagged as risky.
            Yii::$app->getErrorHandler()->unregister();
            Yii::$app = null;
        }
        Yii::$container = new \yii\di\Container();
    }
}
