<?php

namespace Libelula\CommonHelpers\Tests\Stub;

use yii\base\BaseObject;
use yii\web\IdentityInterface;

/**
 * Minimal identity used to exercise Utils::getIDActualUser(), which reads
 * Yii::$app->user->identity->_id.
 */
class StubIdentity extends BaseObject implements IdentityInterface
{
    public $_id;

    public function __construct($id = null, $config = [])
    {
        $this->_id = $id;
        parent::__construct($config);
    }

    public static function findIdentity($id)
    {
        return new self($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }
}
