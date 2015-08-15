<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;

/**
 * Class MethodDataProvider
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodDataProvider
{
    /**
     * A PHP ReflectionMethod instance
     *
     * @var ReflectionMethod
     */
    private $reflectionMethod;

    /**
     * Creates parameter data providers
     *
     * @var ParameterDataProviderFactory
     */
    private $parameterDataProviderFactory;

    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param ReflectionMethod $reflectionMethod
     * @param ParameterDataProviderFactory $parameterDataProviderFactory
     * @param Reader $reader
     */
    public function __construct(ReflectionMethod $reflectionMethod, ParameterDataProviderFactory $parameterDataProviderFactory, Reader $reader)
    {
        $this->reflectionMethod = $reflectionMethod;
        $this->parameterDataProviderFactory = $parameterDataProviderFactory;
        $this->reader = $reader;
    }

    /**
     * Get the name of the method
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflectionMethod->getName();
    }

    /**
     * Get the method
     *
     * @return ParameterDataProvider[]
     */
    public function getParameters()
    {
        $parameters = [];
        foreach ($this->reflectionMethod->getParameters() as $parameter) {
            $parameters[] = $this->parameterDataProviderFactory->make($parameter);
        }

        return $parameters;
    }

    /**
     * Get the method annotations
     *
     * @return array
     */
    public function getAnnotations()
    {
        $annotations = $this->reader->getMethodAnnotations($this->reflectionMethod);

        $reflectionClass = $this->reflectionMethod->getDeclaringClass();
        $parents = $reflectionClass->getInterfaceNames();

        foreach ($parents as $parent) {
            $parentClass = new ReflectionClass($parent);

            try {
                $parentMethod = $parentClass->getMethod($this->getName());
            } catch (ReflectionException $exception) {
                //name does not exist
                continue;
            }

            $parentAnnotations = $this->reader->getMethodAnnotations($parentMethod);
            $annotations = array_merge($annotations, $parentAnnotations);
        }

        return $annotations;
    }
}
