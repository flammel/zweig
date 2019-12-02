<?php

namespace Flammel\Zweig\Component;

use Flammel\Zweig\Exception\ZweigException;

final class ComponentContext implements \ArrayAccess
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toContextArray(): array
    {
        return ['this' => $this];
    }

    /**
     * @param array<string|array> $names
     */
    public function setPropNames(array $names): void
    {
        foreach ($names as $index => $name) {
            if (is_array($name)) {
                $default = $name[1];
                $name = $name[0];
            }
            if (isset($this->data[$index])) {
                $this->data[$name] = $this->data[$index];
            } elseif (isset($default)) {
                $this->data[$name] = $default;
            }
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws ZweigException
     */
    public function offsetGet($offset)
    {
        if (isset($this->data[$offset])) {
            return $this->data[$offset];
        }
        throw new ZweigException(sprintf('Tried to get undefined variable %s from context', $offset));
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws ZweigException
     */
    public function offsetSet($offset, $value)
    {
        throw new ZweigException('Cannot set to the component context');
    }

    /**
     * @param mixed $offset
     * @throws ZweigException
     */
    public function offsetUnset($offset)
    {
        throw new ZweigException('Cannot unset from the component context');
    }
}
