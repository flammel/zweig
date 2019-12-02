<?php

namespace Flammel\Zweig\Component;

use Flammel\Zweig\Exception\ZweigException;

final class ComponentArguments implements \ArrayAccess
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->arguments[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->arguments[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws ZweigException
     */
    public function offsetSet($offset, $value)
    {
        throw new ZweigException('Cannot set to the component arguments');
    }

    /**
     * @param mixed $offset
     * @throws ZweigException
     */
    public function offsetUnset($offset)
    {
        throw new ZweigException('Cannot unset from the component arguments');
    }
}
