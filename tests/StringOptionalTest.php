<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class StringOptionalTest extends TestCase
{
    public function testFirstPositionOf()
    {
        $this->assertTrue(string('foo')->firstOccurrenceOf('o')->isSome($pos));
        $this->assertEquals(1, $pos);
    }

    public function testLastPositionOf()
    {
        $this->assertTrue(string('foo')->lastOccurrenceOf('o')->isSome($pos));
        $this->assertEquals(2, $pos);
    }

    public function testAt()
    {
        $this->assertTrue(string('bar')->at(0)->isSome($c));
        $this->assertEquals('b', $c);

        $this->assertTrue(string('bar')->at(1)->isSome($c));
        $this->assertEquals('a', $c);

        $this->assertTrue(string('bar')->at(2)->isSome($c));
        $this->assertEquals('r', $c);

        $this->assertFalse(string('bar')->at(3)->isSome($c));
        $this->assertNull($c);

        $this->assertTrue(string('bar')->at(3)->isNone());
    }
}