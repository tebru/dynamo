<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Tebru;

/**
 * Class ClassModel
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModel
{
    /**
     * Class namespace
     *
     * @var string
     */
    private $namespace;

    /**
     * Class name
     *
     * @var string
     */
    private $name;

    /**
     * Interface class implements
     *
     * @var string
     */
    private $interface;

    /**
     * Class methods
     *
     * @var MethodModel[]|ArrayCollection
     */
    private $methods;

    /**
     * Class properties
     *
     * @var PropertyModel[]|ArrayCollection
     */
    private $properties;

    /**
     * Constructor
     *
     * @param string $namespace
     * @param string $name
     * @param string $interface
     */
    public function __construct($namespace, $name, $interface)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->interface = $interface;
        $this->methods = new ArrayCollection();
        $this->properties = new ArrayCollection();
    }

    /**
     * Get the class namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the class namespace
     *
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get the class name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the class name
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
     * Return the full class name including namespace
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->namespace . '\\' . $this->name;
    }

    /**
     * Get interface name
     *
     * @return string
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * Add a method to the class
     *
     * @param MethodModel $methodModel
     * @return $this
     */
    public function addMethod(MethodModel $methodModel)
    {
        $methodName = $methodModel->getName();
        Tebru\assertArrayKeyNotExists($methodName, $this->methods->toArray(), 'Method "%s" already exists on class', $methodName);

        $this->methods->set($methodName, $methodModel);

        return $this;
    }

    /**
     * Remove a method from class
     *
     * @param MethodModel $methodModel
     * @return $this
     */
    public function removeMethod(MethodModel $methodModel)
    {
        $this->methods->remove($methodModel->getName());

        return $this;
    }

    /**
     * Get a method by name
     *
     * @param $methodName
     * @return MethodModel
     */
    public function getMethod($methodName)
    {
        Tebru\assertArrayKeyExists($methodName, $this->methods->toArray(), 'Method "%s" does not exist on class', $methodName);

        return $this->methods->get($methodName);
    }

    /**
     * Return all class methods
     *
     * @return MethodModel[]
     */
    public function getMethods()
    {
        return $this->methods->toArray();
    }

    /**
     * Add a property to the class
     *
     * @param PropertyModel $propertyModel
     * @return $this
     */
    public function addProperty(PropertyModel $propertyModel)
    {
        $propertyName = $propertyModel->getName();
        Tebru\assertArrayKeyNotExists($propertyName, $this->properties->toArray(), 'Property "%s" already exists on class', $propertyName);

        $this->properties->set($propertyName, $propertyModel);

        return $this;
    }

    /**
     * Remove a property from class
     *
     * @param PropertyModel $propertyModel
     * @return $this
     */
    public function removeProperty(PropertyModel $propertyModel)
    {
        $this->properties->remove($propertyModel->getName());

        return $this;
    }

    /**
     * Get a property by name
     *
     * @param $propertyName
     * @return PropertyModel
     */
    public function getProperty($propertyName)
    {
        Tebru\assertArrayKeyExists($propertyName, $this->properties->toArray(), 'Property "%s" does not exist on class', $propertyName);

        return $this->properties->get($propertyName);
    }

    /**
     * Return all class properties
     *
     * @return PropertyModel[]
     */
    public function getProperties()
    {
        return $this->properties->toArray();
    }
}
