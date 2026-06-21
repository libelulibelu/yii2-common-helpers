<?php

namespace Libelula\CommonHelpers\Tests;

use Exception;
use Libelula\CommonHelpers\CurlHelpers;
use PHPUnit\Framework\TestCase;

/**
 * CurlHelpers performs real HTTP requests, so only its failure contract is
 * unit-tested here: an unreachable endpoint must raise an Exception. The
 * success path (parsing a real JSON response) is integration-level and is not
 * covered by this suite.
 */
class CurlHelpersTest extends TestCase
{
    public function testGetThrowsOnUnreachableHost(): void
    {
        // 127.0.0.1:9 is the discard port — refuses immediately, no network needed.
        $this->expectException(Exception::class);
        CurlHelpers::get('http://127.0.0.1:9');
    }
}
