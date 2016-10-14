<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class StringTest extends TestCase
{
    public function testFirstReplace()
    {
        $this->assertEquals('Fao Bar', string('Foo Bar')->replaceFirst(['o' => 'a']));
        $this->assertEquals('Faao Bar', string('Foo Bar')->replaceFirst(['o' => 'aa']));
    }

    public function testLastReplace()
    {
        $this->assertEquals('Foa Bar', string('Foo Bar')->replaceLast(['o' => 'a']));
        $this->assertEquals('Foaa Bar', string('Foo Bar')->replaceLast(['o' => 'aa']));
    }

    public function testUnderscored()
    {
        $this->assertEquals('Foo_Bar_Quatz', string('FooBarQuatz')->underscored()->get());
    }

    public function testDasherize()
    {
        $this->assertEquals('Foo-Bar-Quatz', string('FooBarQuatz')->dasherize()->get());
    }

    public function testCamelize()
    {
        $this->assertEquals('fooBarQuatz', string(' foo-bar-quatz ')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo_bar_quatz ')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo.bar.quatz ')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo bar quatz ')->camelize()->get());
    }

    public function testToAscii()
    {
        $this->assertEquals('aaeeiioouuuss', string('áàèéìíóòùúûß')->toAscii());
    }

    public function testBetween()
    {
        $this->assertEquals('Middle', string('StartMiddleEnd')->between('Start', 'End')->get());
        $this->assertEquals('am', string('i am a slug')->between('i', 'a slug')->get());
    }

    public function testPopBack()
    {
        $this->assertEquals('foo/bar', string('foo/bar/baz')->popBack('/')->get());
        $this->assertEquals('foo', string('foo/bar/baz')->popBack('/')->popBack('/')->get());
    }

    public function testPopFront()
    {
        $this->assertEquals('bar/baz', string('foo/bar/baz')->popFront('/')->get());
        $this->assertEquals('baz', string('foo/bar/baz')->popFront('/')->popFront('/')->get());
    }

    public function testSlugify()
    {
        $this->assertEquals('my-new-post', string('My_nEw\\\/  @ post!!!')->slugify()->get());
        $this->assertEquals('my_new_post', string('My nEw post!!!')->slugify('_')->get());
    }
}