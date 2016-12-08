<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\object;

class ObjectTest extends TestCase
{
    public function testIt()
    {
        $obj = object($this);

        $this->assertTrue($obj->hasMethod('dump'));
        $this->assertEquals(42, $obj->invoke('dump'));
        $this->assertEquals(84, $obj->invoke('dump', 2));
        $this->assertTrue($obj->hasProperty('dumper'));
        $this->assertEquals(self::class, $obj->getClass());
    }

    public function dump(int $i = 1): int
    {
        return 42 * $i;
    }
}