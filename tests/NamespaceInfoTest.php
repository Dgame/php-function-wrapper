<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\namespaceOf;

class NamespaceInfoTest extends TestCase
{
    public function testClass()
    {
        $ns = namespaceOf(static::class);

        $this->assertEquals('NamespaceInfoTest', $ns->getClass());
        $this->assertEquals(static::class, $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testExternalClass()
    {
        $ns = namespaceOf('\Exception');

        $this->assertEquals('Exception', $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testNamespace()
    {
        $ns = namespaceOf(TestCase::class);

        $this->assertEquals('TestCase', $ns->getClass());
        $this->assertEquals('PHPUnit\Framework', $ns->getNamespace());
    }
}