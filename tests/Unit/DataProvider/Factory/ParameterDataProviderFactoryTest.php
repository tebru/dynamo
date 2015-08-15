<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider\Factory;

use Mockery;
use ReflectionParameter;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ParameterDataProviderFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterDataProviderFactoryTest extends MockeryTestCase
{
    public function testCanMakeParameterDataProvider()
    {
        $factory = new ParameterDataProviderFactory();
        $provider = $factory->make(Mockery::mock(ReflectionParameter::class));

        $this->assertInstanceOf(ParameterDataProvider::class, $provider);
    }
}
