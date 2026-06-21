<?php

namespace Libelula\CommonHelpers\Tests\Stub;

use yii\web\Request;

/**
 * Test double for yii\web\Request that lets tests set the parsed body params
 * and the raw request body without going through php://input.
 */
class StubRequest extends Request
{
    public array $stubBodyParams = [];
    public ?string $stubRawBody = null;

    public function getBodyParams(): array
    {
        return $this->stubBodyParams;
    }

    public function getRawBody(): string
    {
        return $this->stubRawBody ?? '';
    }
}
