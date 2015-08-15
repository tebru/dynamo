<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model\Factory;

use Mockery;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Model\Factory\ParameterModelFactory;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\ParameterModel;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ParameterModelFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterModelFactoryTest extends MockeryTestCase
{
    public function testCanCreateParameterModel()
    {
        $methodModel = Mockery::mock(MethodModel::class);
        $parameterDataProvider = Mockery::mock(ParameterDataProvider::class);

        $parameterDataProvider->shouldReceive('hasDefaultValue')->times(1)->withNoArgs()->andReturn(true);
        $parameterDataProvider->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testParameter');
        $parameterDataProvider->shouldReceive('getTypeHint')->times(1)->withNoArgs()->andReturn('array');
        $parameterDataProvider->shouldReceive('getDefaultValue')->times(1)->withNoArgs()->andReturn([]);

        $factory = new ParameterModelFactory();
        $parameterModel = $factory->make($methodModel, $parameterDataProvider);

        $this->assertInstanceOf(ParameterModel::class, $parameterModel);
        $this->assertSame('testParameter', $parameterModel->getName());
        $this->assertTrue($parameterModel->isArray());
        $this->assertSame([], $parameterModel->getDefaultValue());
    }
}
