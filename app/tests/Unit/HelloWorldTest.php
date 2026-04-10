<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class HelloWorldTest extends TestCase
{
    public function testHelloWorld(): void
    {
        $this->assertSame('hello world', 'hello world');
    }
}
