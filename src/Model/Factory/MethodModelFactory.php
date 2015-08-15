<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model\Factory;

use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\MethodModel;

/**
 * Class MethodModelFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodModelFactory
{
    /**
     * Creates new parameter models
     *
     * @var ParameterModelFactory
     */
    private $parameterModelFactory;

    /**
     * Constructor
     *
     * @param ParameterModelFactory $parameterModelFactory
     */
    public function __construct(ParameterModelFactory $parameterModelFactory)
    {
        $this->parameterModelFactory = $parameterModelFactory;
    }

    /**
     * Create a new method model
     *
     * @param ClassModel $classModel
     * @param MethodDataProvider $methodDataProvider
     * @return MethodModel
     */
    public function make(ClassModel $classModel, MethodDataProvider $methodDataProvider)
    {
        $methodModel = new MethodModel($classModel, $methodDataProvider->getName());

        $parameters = $methodDataProvider->getParameters();
        foreach ($parameters as $parameterDataProvider) {
            $parameter = $this->parameterModelFactory->make($methodModel, $parameterDataProvider);
            $methodModel->addParameter($parameter);
        }

        return $methodModel;
    }
}
