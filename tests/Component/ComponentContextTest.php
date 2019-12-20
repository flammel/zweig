<?php

namespace Flammel\Zweig\Tests\Component;

use Flammel\Zweig\Component\ComponentContext;
use Flammel\Zweig\Exception\ZweigException;
use PHPUnit\Framework\TestCase;

class ComponentContextTest extends TestCase
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var ComponentContext
     */
    private $obj;

    public function setUp(): void
    {
        $this->data = ['x' => 'x', 1 => ['y' => 2]];
        $this->obj = new ComponentContext($this->data);
    }

    public function testToArrayReturnsArguments(): void
    {
        $this->assertSame(['props' => $this->data], $this->obj->toContextArray());
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
        $this->assertEquals($this->data['x'], $this->obj['x']);
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
