<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider;

use ReflectionMethod;
use Tebru\Dynamo\DataProvider\Factory\AnnotationDataProviderFactory;
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
     * Returns method and class annotations
     *
     * @var AnnotationDataProviderFactory
     */
    private $annotationDataProviderFactory;

    /**
     * Constructor
     *
     * @param ReflectionMethod $reflectionMethod
     * @param ParameterDataProviderFactory $parameterDataProviderFactory
     * @param AnnotationDataProviderFactory $annotationDataProviderFactory
     */
    public function __construct(
        ReflectionMethod $reflectionMethod,
        ParameterDataProviderFactory $parameterDataProviderFactory,
        AnnotationDataProviderFactory $annotationDataProviderFactory
    ) {
        $this->reflectionMethod = $reflectionMethod;
        $this->parameterDataProviderFactory = $parameterDataProviderFactory;
        $this->annotationDataProviderFactory = $annotationDataProviderFactory;
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
     * Get the method annotations including the class annotations
     *
     * @return array
     */
    public function getAnnotations()
    {
        $annotationProvider = $this->annotationDataProviderFactory->make($this->reflectionMethod);

        return $annotationProvider->getAnnotations();
    }
}
