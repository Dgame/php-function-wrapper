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
}