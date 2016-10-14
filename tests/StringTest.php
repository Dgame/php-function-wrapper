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
        $this->assertEquals('fooBarQuatz', string('foo-bar-quatz')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string('foo_bar_quatz')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string('foo.bar.quatz')->camelize()->get());
        $this->assertEquals('fooBarQuatz', string('foo bar quatz')->camelize()->get());
    }

    public function testCollapseWhitespaces()
    {
        $this->assertEquals('foobarquatz', string(' foo     bar  quatz  ')->collapseWhitespaces()->get());
    }

    public function testToAscii()
    {
        $this->assertEquals('aaeeiioouuuss', string('áàèéìíóòùúûß')->toAscii());
    }
}