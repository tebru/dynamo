<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
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
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param ParameterDataProviderFactory $parameterDataProviderFactory
     * @param Reader $reader
     */
    public function __construct(ParameterDataProviderFactory $parameterDataProviderFactory, Reader $reader)
    {
        $this->parameterDataProviderFactory = $parameterDataProviderFactory;
        $this->reader = $reader;
    }
    /**
     * Create a new method data provider
     *
     * @param ReflectionMethod $method
     * @return MethodDataProvider
     */
    public function make(ReflectionMethod $method)
    {
        return new MethodDataProvider($method, $this->parameterDataProviderFactory, $this->reader);
    }
}
