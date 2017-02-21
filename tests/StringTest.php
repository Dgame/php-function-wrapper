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
        $this->assertEquals('fooBarQuatz', string('_foo bar quatz.')->camelize()->get());
    }

    public function testUncamelize()
    {
        $this->assertEquals('foo-bar-quatz', string('fooBarQuatz')->unCamelize('-')->get());
        $this->assertEquals('foo_bar_quatz', string('fooBarQuatz')->unCamelize('_')->get());
        $this->assertEquals('foo.bar.quatz', string('fooBarQuatz')->unCamelize('.')->get());
    }

    public function testTitelize()
    {
        $this->assertEquals('FooBarQuatz', string('foo_bar_quatz')->titelize()->get());
        $this->assertEquals('FooBarQuatz', string('foo.bar.quatz')->titelize()->get());
        $this->assertEquals('FooBarQuatz', string('foo-bar-quatz')->titelize()->get());
    }

    public function testUntitelize()
    {
        $this->assertEquals('foo_bar_quatz', string('FooBarQuatz')->unTitelize('_')->get());
        $this->assertEquals('foo.bar.quatz', string('FooBarQuatz')->unTitelize('.')->get());
        $this->assertEquals('foo-bar-quatz', string('FooBarQuatz')->unTitelize('-')->get());
    }

    public function testBetween()
    {
        $this->assertEquals('Middle', string('StartMiddleEnd')->between('Start', 'End')->get());
        $this->assertEquals('am', string('i am a slug')->between('i', 'a slug')->get());
    }

    public function testPopBack()
    {
        $this->assertEquals('foo/bar', string('foo/bar/baz')->popBack('/')->getString());
        $this->assertEquals('foo', string('foo/bar/baz')->popBack('/')->popBack('/')->getString());
    }

    public function testPopFront()
    {
        $this->assertEquals('bar/baz', string('foo/bar/baz')->popFront('/')->getString());
        $this->assertEquals('baz', string('foo/bar/baz')->popFront('/')->popFront('/')->getString());
    }

    public function testSlugify()
    {
        $this->assertEquals('my-new-post', string('My_nEw\\\/  @ post!!!')->slugify()->get());
        $this->assertEquals('my_new_post', string('My nEw post!!!')->slugify('_')->get());
    }

    public function testSlice()
    {
        $this->assertEquals('oBar', string('FooBarQuatz')->slice(2, 6)->get());
    }

    public function testSubstring()
    {
        $this->assertEquals('oBar', string('FooBarQuatz')->substring(2, 4)->get());
    }
}