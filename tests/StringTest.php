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
        $this->assertEquals('Foo_Bar_Quatz', string('FooBarQuatz')->convert()->underscored()->get());
    }

    public function testDasherize()
    {
        $this->assertEquals('Foo-Bar-Quatz', string('FooBarQuatz')->convert()->dasherize()->get());
    }

    public function testCamelize()
    {
        $this->assertEquals('fooBarQuatz', string(' foo-bar-quatz ')->convert()->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo_bar_quatz ')->convert()->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo.bar.quatz ')->convert()->camelize()->get());
        $this->assertEquals('fooBarQuatz', string(' foo bar quatz ')->convert()->camelize()->get());
    }

    public function testBetween()
    {
        $this->assertEquals('Middle', string('StartMiddleEnd')->iter()->between('Start', 'End')->get());
        $this->assertEquals('am', string('i am a slug')->iter()->between('i', 'a slug')->get());
    }

    public function testPopBack()
    {
        $this->assertEquals('foo/bar', string('foo/bar/baz')->iter()->popBack('/')->asString());
        $this->assertEquals('foo', string('foo/bar/baz')->iter()->popBack('/')->popBack('/')->asString());
    }

    public function testPopFront()
    {
        $this->assertEquals('bar/baz', string('foo/bar/baz')->iter()->popFront('/')->asString());
        $this->assertEquals('baz', string('foo/bar/baz')->iter()->popFront('/')->popFront('/')->asString());
    }

    public function testSlugify()
    {
        $this->assertEquals('my-new-post', string('My_nEw\\\/  @ post!!!')->convert()->slugify()->get());
        $this->assertEquals('my_new_post', string('My nEw post!!!')->convert()->slugify('_')->get());
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