<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model;

/**
 * Class ParameterModel
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterModel
{
    /**
     * Reference to method model
     *
     * @var MethodModel
     */
    private $methodModel;

    /**
     * Method parameter name
     *
     * @var string
     */
    private $name;

    /**
     * If the parameter is optional
     *
     * @var bool
     */
    private $optional;

    /**
     * Parameter typeHint
     *
     * @var string
     */
    private $typeHint;

    /**
     * Parameter default value
     *
     * @var mixed
     */
    private $defaultValue;

    /**
     * Constructor
     *
     * @param MethodModel $methodModel
     * @param string $name
     * @param bool $optional
     */
    public function __construct(MethodModel $methodModel, $name, $optional)
    {
        $this->methodModel = $methodModel;
        $this->name = $name;
        $this->optional = $optional;
    }

    /**
     * Get the method model
     *
     * @return MethodModel
     */
    public function getMethodModel()
    {
        return $this->methodModel;
    }

    /**
     * Get the parameter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the parameter name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Is the parameter an optional parameter
     *
     * @return boolean
     */
    public function isOptional()
    {
        return $this->optional;
    }

    /**
     * Set if the parameter is optional
     *
     * @param boolean $optional
     * @return $this
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;

        return $this;
    }

    /**
     * Get the parameter typeHint
     *
     * @return string
     */
    public function getTypeHint()
    {
        return $this->typeHint;
    }

    /**
     * Set the parameter typeHint
     *
     * @param string $typeHint
     * @return $this
     */
    public function setTypeHint($typeHint)
    {
        $this->typeHint = $typeHint;

        return $this;
    }

    /**
     * If the parameter has a typeHint
     *
     * @return bool
     */
    public function hasTypeHint()
    {
        return !empty($this->typeHint);
    }

    /**
     * If the typeHint is an array
     *
     * @return bool
     */
    public function isArray()
    {
        return 'array' === $this->typeHint;
    }

    /**
     * If the typeHint is a callable
     *
     * @return bool
     */
    public function isCallable()
    {
        return 'callable' === $this->typeHint;
    }

    /**
     * If the typeHint is an int
     *
     * @return bool
     */
    public function isInt()
    {
        return 'int' === $this->typeHint;
    }

    /**
     * If the typeHint is a boolean
     *
     * @return bool
     */
    public function isBool()
    {
        return 'bool' === $this->typeHint;
    }

    /**
     * If the typeHint is a string
     *
     * @return bool
     */
    public function isString()
    {
        return 'string' === $this->typeHint;
    }

    /**
     * If the typeHint is a float
     *
     * @return bool
     */
    public function isFloat()
    {
        return 'float' === $this->typeHint;
    }

    /**
     * If the typeHint is a class
     *
     * @return bool
     */
    public function isObject()
    {
        return (class_exists($this->typeHint) || interface_exists($this->typeHint));
    }

    /**
     * Get the parameter default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set the parameter default value
     *
     * @param mixed $defaultValue
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }
}
