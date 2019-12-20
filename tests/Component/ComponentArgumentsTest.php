<?php

namespace Flammel\Zweig\Tests\Component;

use Flammel\Zweig\Component\ComponentArguments;
use Flammel\Zweig\Exception\ZweigException;
use PHPUnit\Framework\TestCase;

class ComponentArgumentsTest extends TestCase
{
    /**
     * @var array
     */
    private $args;

    /**
     * @var ComponentArguments
     */
    private $obj;

    public function setUp(): void
    {
        $this->args = ['x' => 'x', 1 => ['y' => 2]];
        $this->obj = new ComponentArguments($this->args);
    }

    public function testToArrayReturnsArguments(): void
    {
        $this->assertSame($this->args, $this->obj->toArray());
    }

    public function testOffsetExistsTrue(): void
    {
        $this->assertTrue(isset($this->obj['x']));
    }

    public function testOffsetExistsFalse(): void
    {
        $this->assertFalse(isset($this->obj['y']));
    }

    public function testOffsetGetSuccess(): void
    {
        $this->assertEquals($this->args['x'], $this->obj['x']);
    }

    public function testOffsetGetFailure(): void
    {
        $this->expectException(ZweigException::class);
        $this->obj['y'];
    }

    public function testOffsetSet(): void
    {
        $this->expectException(ZweigException::class);
        $this->obj['y'] = 1;
    }

    public function testOffsetUnset(): void
    {
        $this->expectException(ZweigException::class);
        unset($this->obj['x']);
    }
}
