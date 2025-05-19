<?php
use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    public function testHelloWorld()
    {
        $this->assertEquals('Hello, World!', $this->getHelloWorld());
    }

    private function getHelloWorld()
    {
        return 'Hello, World!';
    }
}
