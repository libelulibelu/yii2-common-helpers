<?php

// PHPUnit bootstrap: autoloader + Yii framework bootstrap for tests that need an app.

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

// Deterministic timezone for date-based assertions (Utils helpers).
date_default_timezone_set('UTC');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@tests', __DIR__);
