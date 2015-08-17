<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use Tebru;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;

/**
 * Class InterfaceDataProvider
 *
 * @author Nate Brunette <n@tebru.net>
 */
class InterfaceDataProvider
{
    /**
     * Interface reflection class
     *
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * Create a method data provider
     *
     * @var MethodDataProviderFactory
     */
    private $methodDataProviderFactory;

    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param string $interfaceName
     * @param MethodDataProviderFactory $methodDataProviderFactory
     * @param Reader $reader
     */
    public function __construct($interfaceName, MethodDataProviderFactory $methodDataProviderFactory, Reader $reader)
    {
        Tebru\assertThat(interface_exists($interfaceName), '"%s" is not a valid interface', $interfaceName);

        $this->reflectionClass = new ReflectionClass($interfaceName);
        $this->methodDataProviderFactory = $methodDataProviderFactory;
        $this->reader = $reader;
    }

    /**
     * Get the full interface filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->reflectionClass->getFileName();
    }

    /**
     * Get interface namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->reflectionClass->getNamespaceName();
    }

    /**
     * Get the interface name
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflectionClass->getShortName();
    }

    /**
     * Get the full interface name including namespace
     *
     * @return string
     */
    public function getFullName()
    {
        return '\\' . $this->reflectionClass->getName();
    }

    /**
     * Gets all interface names of all parents
     *
     * @return array
     */
    public function getParents()
    {
        return $this->reflectionClass->getInterfaceNames();
    }

    /**
     * Gets all constants in all interfaces
     *
     * @return array
     */
    public function getConstants()
    {
        return $this->reflectionClass->getConstants();
    }

    /**
     * Return an array of method data providers created from ReflectionMethod objects
     *
     * @return MethodDataProvider[]
     */
    public function getMethods()
    {
        $methods = [];
        foreach ($this->reflectionClass->getMethods() as $method) {
            $methods[] = $this->methodDataProviderFactory->make($method);
        }

        return $methods;
    }
}
