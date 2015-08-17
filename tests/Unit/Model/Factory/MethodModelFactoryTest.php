<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model\Factory;

use Mockery;
use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\Factory\MethodModelFactory;
use Tebru\Dynamo\Model\Factory\ParameterModelFactory;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\ParameterModel;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class MethodModelFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodModelFactoryTest extends MockeryTestCase
{
    public function testCanCreateMethodModelFactory()
    {
        $parameterModelFactory = Mockery::mock(ParameterModelFactory::class);
        $factory = new MethodModelFactory($parameterModelFactory);

        $this->assertInstanceOf(MethodModelFactory::class, $factory);
    }

    public function testCanCreateMethodModel()
    {
        $parameterModelFactory = Mockery::mock(ParameterModelFactory::class);
        $classModel = Mockery::mock(ClassModel::class);
        $methodDataProvider = Mockery::mock(MethodDataProvider::class);
        $parameterDataProvider = Mockery::mock(ParameterDataProvider::class);
        $parameterModel = Mockery::mock(ParameterModel::class);

        $methodDataProvider->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testMethod');
        $methodDataProvider->shouldReceive('getParameters')->times(1)->withNoArgs()->andReturn([$parameterDataProvider]);
        $parameterModelFactory->shouldReceive('make')->times(1)->with(Mockery::type(MethodModel::class), $parameterDataProvider)->andReturn($parameterModel);
        $parameterModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testParameter');

        $factory = new MethodModelFactory($parameterModelFactory);
        $methodModel = $factory->make($classModel, $methodDataProvider);

        $this->assertInstanceOf(MethodModel::class, $methodModel);
        $this->assertSame('testMethod', $methodModel->getName());
        $this->assertCount(1, $methodModel->getParameters());
    }
}
