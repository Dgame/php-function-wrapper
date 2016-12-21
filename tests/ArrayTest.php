<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\assoc;
use function Dgame\Wrapper\chars;

class ArrayTest extends TestCase
{
    public function testValueOf()
    {
        $this->assertTrue(assoc(['id' => '123', 'data' => 'foo'])->valueOf('data')->isSome($value));
        $this->assertEquals('foo', $value);
        $this->assertTrue(assoc(['id' => '123', 'data' => 'foo'])->valueOf('foo')->isNone());
        $this->assertEquals(0, assoc(['id' => '123', 'data' => 'foo'])->valueOf('foo')->default(0));
    }

    public function testColumn()
    {
        $data = [
            ['id' => '123', 'data' => 'foo'],
            ['id' => '345', 'data' => 'bar'],
        ];

        $this->assertEquals(['123', '345'], assoc($data)->column('id')->get());

        $records = assoc([
                             [
                                 'id'         => 2135,
                                 'first_name' => 'John',
                                 'last_name'  => 'Doe',
                             ],
                             [
                                 'id'         => 3245,
                                 'first_name' => 'Sally',
                                 'last_name'  => 'Smith',
                             ],
                             [
                                 'id'         => 5342,
                                 'first_name' => 'Jane',
                                 'last_name'  => 'Jones',
                             ],
                             [
                                 'id'         => 5623,
                                 'first_name' => 'Peter',
                                 'last_name'  => 'Doe',
                             ]
                         ]);

        $this->assertEquals(['John', 'Sally', 'Jane', 'Peter'], $records->column('first_name')->get());
        $this->assertEquals(
            [2135 => 'Doe', 3245 => 'Smith', 5342 => 'Jones', 5623 => 'Doe'],
            $records->column('last_name', 'id')->get()
        );
    }

    public function testGroupValues()
    {
        $this->assertEquals(
            [[1, 1], [2, 2, 2, 2], [4, 4, 4], [3], [5]],
            assoc([1, 2, 4, 2, 3, 2, 4, 5, 1, 2, 4])->group()->byValues()->asArray()
        );

        $this->assertEquals(
            [[0, 0], [1]],
            assoc(['a' => 0, 'b' => 1, 'c' => 0])->group()->byValues()->asArray()
        );

        $this->assertEquals(
            [['a' => 0, 'c' => 0], ['b' => 1]],
            assoc(['a' => 0, 'b' => 1, 'c' => 0])->group()->byValuesWithKeys()->asArray()
        );
    }

    public function testGroupByKey()
    {
        $data = [
            ['id' => '123', 'data' => 'foo'],
            ['id' => '345', 'data' => 'bar'],
            ['id' => '345', 'data' => 'quatz'],
        ];

        $result = [
            '123' => ['id' => '123', 'data' => 'foo'],
            '345' => ['id' => '345', 'data' => 'quatz']
        ];

        $this->assertEquals($result, assoc($data)->group()->ByKey('id')->asArray());
    }

    public function testOnly()
    {
        $this->assertEquals(
            ['a' => 0, 'c' => 2],
            assoc(['a' => 0, 'b' => 1, 'c' => 2])->only(['a', 'c'])->get()
        );
    }

    public function testTake()
    {
        $this->assertEquals('Ha', chars('Hallo')->iter()->take(2)->implode()->get());
    }

    public function testSkip()
    {
        $this->assertEquals('lo', chars('Hallo')->iter()->skip(3)->implode()->get());
    }

    public function testSlice()
    {
        $this->assertEquals('oBar', chars('FooBarQuatz')->slice(2, 6)->implode()->get());
    }

    public function testRange()
    {
        $this->assertEquals('oBar', chars('FooBarQuatz')->range(2, 4)->implode()->get());
    }

    public function testChunks()
    {
        $this->assertEquals([['F', 'o'], ['o', 'B'], ['a', 'r']], chars('FooBar')->chunks(2)->get());
    }

    public function testCountOccurences()
    {
        $this->assertEquals(
            [1 => 2, 'hello' => 2, 'world' => 1],
            assoc([1, 'hello', 1, 'world', 'hello'])->countOccurrences()
        );
    }

    public function testReduce()
    {
        $sum1 = function($sum, int $a) {
            return $sum + $a;
        };

        $sum2 = function(int $sum, int $a) {
            return $sum + $a;
        };

        $this->assertEquals(21, assoc([6, 7, 8])->reduce($sum1));
        $this->assertEquals(63, assoc([6, 7, 8])->reduce($sum2, 42));
    }

    public function testTakeWhile()
    {
        $belowTen = function(int $item) {
            return $item < 10;
        };

        $this->assertEquals([0, 1, 2, 8], assoc([0, 1, 2, 8, 10, 15, 20])->iter()->takeWhile($belowTen)->get());
    }

    public function testTakeIf()
    {
        $inRange = function(int $item) {
            return $item > 3 && $item < 10;
        };

        $this->assertEquals(
            [4, 7, 8],
            assoc([0, 1, 2, 3, 4, 7, 8, 10, 15, 20])->iter()->takeIf($inRange)->values()->get()
        );
    }

    public function testSkipWhile()
    {
        $belowTen = function(int $item) {
            return $item < 10;
        };

        $this->assertEquals([10, 15, 20], assoc([0, 1, 2, 10, 15, 20])->iter()->skipWhile($belowTen)->get());
    }

    public function testSkipIf()
    {
        $inRange = function(int $item) {
            return $item > 3 && $item < 10;
        };

        $this->assertEquals(
            [0, 1, 2, 3, 10, 15, 20],
            assoc([0, 1, 2, 3, 4, 7, 8, 10, 15, 20])->iter()->skipIf($inRange)->values()->get()
        );
    }

    public function testBetween()
    {
        $this->assertEquals([2, 10, 20], assoc([0, 1, 2, 10, 20, 30, 40])->iter()->between(1, 30)->values()->get());
        $this->assertEquals(['c' => 'd'], assoc(['a' => 'b', 'c' => 'd', 'e' => 'f'])->iter()->between('b', 'f')->get());
        $this->assertEquals('ooB', chars('FooBar')->iter()->between('F', 'a')->implode()->get());
    }

    public function testEmptyBetween()
    {
        $this->assertTrue(assoc([0, 1, 2, 10, 20, 30, 40])->iter()->between(20, 1)->isEmpty());
        $this->assertTrue(assoc(['a' => 'b', 'c' => 'd', 'e' => 'f'])->iter()->between('f', 'b')->isEmpty());
        $this->assertTrue(chars('FooBar')->iter()->between('a', 'F')->implode()->isEmpty());
    }

    public function testBefore()
    {
        $this->assertEquals('ab', chars('abcdef')->iter()->before('c')->implode()->get());
    }

    public function testBeforeAssoc()
    {
        $this->assertEquals(
            ['a' => 'z', 'b' => 'y'],
            assoc(['a' => 'z', 'b' => 'y', 'c' => 'x', 'd' => 'w'])->iter()->before('x')->get()
        );
    }

    public function testAfter()
    {
        $this->assertEquals('ef', chars('abcdef')->iter()->after('d')->implode()->get());
    }

    public function testAfterAssoc()
    {
        $this->assertEquals(
            ['d' => 'w'],
            assoc(['a' => 'z', 'b' => 'y', 'c' => 'x', 'd' => 'w'])->iter()->after('x')->get()
        );
    }

    public function testFrom()
    {
        $this->assertEquals('def', chars('abcdef')->iter()->from('d')->implode()->get());
    }

    public function testFromAssoc()
    {
        $this->assertEquals(
            ['c' => 'x', 'd' => 'w'],
            assoc(['a' => 'z', 'b' => 'y', 'c' => 'x', 'd' => 'w'])->iter()->from('x')->get()
        );
    }

    public function testUntil()
    {
        $this->assertEquals('abc', chars('abcdef')->iter()->until('c')->implode()->get());
    }

    public function testUntilAssoc()
    {
        $this->assertEquals(
            ['a' => 'z', 'b' => 'y', 'c' => 'x'],
            assoc(['a' => 'z', 'b' => 'y', 'c' => 'x', 'd' => 'w'])->iter()->until('x')->get()
        );
    }

    public function testAll()
    {
        $positive = function(int $item) {
            return $item >= 0;
        };

        $this->assertTrue(assoc([0, 1, 2, 3])->iter()->all($positive));
        $this->assertFalse(assoc([-1, 2, 3, 4])->iter()->all($positive));
    }

    public function testAny()
    {
        $positive = function(int $item) {
            return $item > 0;
        };

        $this->assertTrue(assoc([-1, 0, 1])->iter()->any($positive));
        $this->assertFalse(assoc([-1])->iter()->any($positive));
    }

    public function testSum()
    {
        $this->assertEquals(6, assoc([1, 2, 3])->sum());
    }

    public function testProduct()
    {
        $this->assertEquals(24, assoc([1, 2, 3, 4])->product());
    }

    public function testMax()
    {
        $this->assertEquals(4, assoc([1, 2, 3, 4])->max());
    }

    public function testMin()
    {
        $this->assertEquals(1, assoc([1, 2, 3, 4])->min());
    }

    public function testSearch()
    {
        $this->assertTrue(assoc(['a', 'b', 'c'])->search('a')->isSome($key));
        $this->assertEquals(0, $key);
        $this->assertTrue(chars('foo')->search('o')->isSome($key));
        $this->assertEquals(1, $key);
        $this->assertTrue(assoc(['a', 'b', 'c'])->search('z')->isNone());
    }

    public function testSearchAll()
    {
        $this->assertEquals([1, 2], chars('foo')->searchAll('o'));
        $this->assertEquals([1], chars('fo')->searchAll('o'));
    }

    public function testLength()
    {
        $this->assertEquals(11, assoc(range(0, 10))->length());
        $this->assertEquals(10, chars('Hallo Welt')->length());
    }

    public function testRemoveKey()
    {
        $this->assertEquals(['b' => 'y'], assoc(['a' => 'z', 'b' => 'y'])->removeKey('a')->get());
    }

    public function testRemoveValues()
    {
        $this->assertEquals(['b', 'c', 'd', 'e'], assoc(['a', 'b', 'c', 'a', 'd', 'e', 'a'])->removeValue('a')->values()->get());
        $this->assertEquals(['y' => 'b', 'x' => 'c', 'v' => 'd', 'u' => 'e'],
                            assoc(['z' => 'a', 'y' => 'b', 'x' => 'c', 'w' => 'a', 'v' => 'd', 'u' => 'e'])->removeValue('a')->get()
        );
    }

    public function testMapping()
    {
        $records = [
            ['id' => 123, 'name' => 'foo', 'test' => 'a'],
            ['id' => 124, 'name' => 'bar', 'test' => 'a'],
            ['id' => 345, 'name' => 'quatz', 'test' => 'a'],
        ];

        $this->assertEquals([123 => 'foo', 124 => 'bar', 345 => 'quatz'], assoc($records)->process()->mapping('id', 'name')->get());

        $records = [
            ['id' => 123, 'name' => 'foo', 'test' => 'a'],
            ['id' => 123, 'name' => 'bar', 'test' => 'a'],
            ['id' => 345, 'name' => 'quatz', 'test' => 'a'],
        ];

        $this->assertEquals([123 => 'bar', 345 => 'quatz'], assoc($records)->process()->mapping('id', 'name')->get());
    }

    public function testBasic()
    {
        $records = [
            ['id' => 123, 'name' => 'foo', 'test' => 'a'],
            ['id' => 124, 'name' => 'bar', 'test' => 'a'],
            ['id' => 345, 'name' => 'quatz', 'test' => 'a'],
        ];

        $this->assertEquals(['id' => 123, 'name' => 'foo', 'test' => 'a'], assoc($records)->at(0));
        $this->assertEquals(['id' => 124, 'name' => 'bar', 'test' => 'a'], assoc($records)->at(1));
        $this->assertEquals(['id' => 345, 'name' => 'quatz', 'test' => 'a'], assoc($records)->at(2));
    }
}