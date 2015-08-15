<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider;

use ReflectionParameter;

/**
 * Class ParameterDataProvider
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterDataProvider
{
    /**
     * A PHP ReflectionParameter instance
     *
     * @var ReflectionParameter
     */
    private $reflectionParameter;

    /**
     * Constructor
     *
     * @param ReflectionParameter $reflectionParameter
     */
    public function __construct(ReflectionParameter $reflectionParameter)
    {
        $this->reflectionParameter = $reflectionParameter;
    }

    /**
     * Get the typeHint as a string
     *
     * @return string
     */
    public function getTypeHint()
    {
        if (null !== $this->reflectionParameter->getClass()) {
            return '\\' . $this->reflectionParameter->getClass()->name;
        }

        if (true === $this->reflectionParameter->isArray()) {
            return 'array';
        }

        if (true === $this->reflectionParameter->isCallable()) {
            return 'callable';
        }

        return '';
    }

    /**
     * Get the parameter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflectionParameter->getName();
    }

    /**
     * Returns true/false if there is a default value
     *
     * @return bool
     */
    public function hasDefaultValue()
    {
        return $this->reflectionParameter->isDefaultValueAvailable();
    }

    /**
     * Get the parameter default value
     *
     * @return string|null
     */
    public function getDefaultValue()
    {
        return $this->reflectionParameter->getDefaultValue();
    }
}
