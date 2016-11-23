<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class NamespaceInfoTest extends TestCase
{
    public function testClass()
    {
        $ns = string(static::class)->namespaceInfo();

        $this->assertEquals('NamespaceInfoTest', $ns->getClass());
        $this->assertEquals(static::class, $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testExternalClass()
    {
        $ns = string('\Exception')->namespaceInfo();

        $this->assertEquals('Exception', $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testNamespace()
    {
        $ns = string(TestCase::class)->namespaceInfo();

        $this->assertEquals('TestCase', $ns->getClass());
        $this->assertEquals('PHPUnit\Framework', $ns->getNamespace());
    }
}