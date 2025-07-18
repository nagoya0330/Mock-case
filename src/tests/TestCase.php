<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // テスト中はCSRFミドルウェアを無効化（419回避）
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }
}
