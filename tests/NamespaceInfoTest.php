<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class NamespaceInfoTest extends TestCase
{
    public function testClass()
    {
        $ns = string(static::class)->namespaceInfo();

        $this->assertTrue($ns->getClass()->isSome($class));
        $this->assertEquals('NamespaceInfoTest', $class);
        $this->assertEquals(static::class, $class);
        $this->assertTrue($ns->getNamespace()->isNone());
    }

    public function testExternalClass()
    {
        $ns = string('\Exception')->namespaceInfo();

        $this->assertTrue($ns->getClass()->isSome($class));
        $this->assertEquals('Exception', $class);
        $this->assertTrue($ns->getNamespace()->isNone());
    }

    public function testNamespace()
    {
        $ns = string(TestCase::class)->namespaceInfo();

        $this->assertTrue($ns->getClass()->isSome($class));
        $this->assertEquals('TestCase', $class);
        $this->assertTrue($ns->getNamespace()->isSome($namespace));
        $this->assertEquals('PHPUnit\Framework', $namespace);
    }
}