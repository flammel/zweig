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
    public function toArray(): array
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
     * @throws ZweigException
     */
    public function offsetGet($offset)
    {
        if (isset($this->arguments[$offset])) {
            return $this->arguments[$offset];
        }
        throw new ZweigException('Undefined component argument ' . $offset);
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
