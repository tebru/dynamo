<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
use Mockery;
use ReflectionMethod;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;
use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class MethodDataProviderFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodDataProviderFactoryTest extends MockeryTestCase
{
    public function testCanCreateMethodDataProvider()
    {
        $factory = new MethodDataProviderFactory(Mockery::mock(ParameterDataProviderFactory::class), Mockery::mock(Reader::class));
        $provider = $factory->make(Mockery::mock(ReflectionMethod::class));

        $this->assertInstanceOf(MethodDataProvider::class, $provider);
    }
}
