<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\assoc;

class ArrayOptionalTest extends TestCase
{
    public function testSearch()
    {
        $this->assertTrue(assoc([1, 2, 3])->search(2)->isSome($index));
        $this->assertEquals(1, $index);

        $this->assertTrue(assoc([1, 2, 3])->search(4)->isNone());
    }

    public function testIndexOf()
    {
        $this->assertTrue(assoc([1, 2, 3])->indexOf(2)->isSome($index));
        $this->assertEquals(1, $index);

        $this->assertTrue(assoc([1, 2, 3])->indexOf(4)->isNone());
    }

    public function testAt()
    {
        $this->assertTrue(assoc([1, 2, 3])->at(1)->isSome($value));
        $this->assertEquals(2, $value);

        $this->assertTrue(assoc([1, 2, 3])->at(3)->isNone());
    }

    public function testFind()
    {
        $this->assertTrue(assoc([1, 2, 3])->find(2)->isSome($value));
        $this->assertEquals(2, $value);

        $this->assertTrue(assoc([1, 2, 3])->find(4)->isNone());
    }

    public function testPop()
    {
        $assoc = assoc([1, 2, 3]);

        $this->assertTrue($assoc->pop()->isSome($value));
        $this->assertEquals(3, $value);

        $this->assertTrue($assoc->pop()->isSome($value));
        $this->assertEquals(2, $value);

        $this->assertTrue($assoc->pop()->isSome($value));
        $this->assertEquals(1, $value);

        $this->assertTrue($assoc->pop()->isNone());
    }

    public function testShift()
    {
        $assoc = assoc([1, 2, 3]);

        $this->assertTrue($assoc->shift()->isSome($value));
        $this->assertEquals(1, $value);

        $this->assertTrue($assoc->shift()->isSome($value));
        $this->assertEquals(2, $value);

        $this->assertTrue($assoc->shift()->isSome($value));
        $this->assertEquals(3, $value);

        $this->assertTrue($assoc->shift()->isNone());
    }
}