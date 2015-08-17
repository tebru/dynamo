<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider\Factory;

use ReflectionMethod;
use Tebru\Dynamo\DataProvider\MethodDataProvider;

/**
 * Class MethodDataProviderFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodDataProviderFactory
{
    /**
     * Creates parameter data providers
     *
     * @var ParameterDataProviderFactory
     */
    private $parameterDataProviderFactory;

    /**
     * Creates annotation data providers
     *
     * @var AnnotationDataProviderFactory
     */
    private $annotationDataProviderFactory;

    /**
     * Constructor
     *
     * @param ParameterDataProviderFactory $parameterDataProviderFactory
     * @param AnnotationDataProviderFactory $annotationDataProviderFactory
     */
    public function __construct(ParameterDataProviderFactory $parameterDataProviderFactory, AnnotationDataProviderFactory $annotationDataProviderFactory)
    {
        $this->parameterDataProviderFactory = $parameterDataProviderFactory;
        $this->annotationDataProviderFactory = $annotationDataProviderFactory;
    }
    /**
     * Create a new method data provider
     *
     * @param ReflectionMethod $method
     * @return MethodDataProvider
     */
    public function make(ReflectionMethod $method)
    {
        return new MethodDataProvider($method, $this->parameterDataProviderFactory, $this->annotationDataProviderFactory);
    }
}
