<?php
namespace Test;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $app = null;
    protected function setUp(): void
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $this->app = $app;
    }
    protected function tearDown(): void
    {
        $this->app->flush();
    }
}
