<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use Doctrine\Common\Annotations\AnnotationReader;
use Mockery;
use ReflectionClass;
use ReflectionParameter;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;
use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class MethodDataProviderTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodDataProviderTest extends MockeryTestCase
{
    public function testCanCreateMethodDataProvider()
    {
        $provider = $this->getProvider();

        $this->assertInstanceOf(MethodDataProvider::class, $provider);
    }

    public function testGetMethodName()
    {
        $provider = $this->getProvider();

        $this->assertSame('method1', $provider->getName());
    }

    public function testGetMethodParameters()
    {
        $factory = Mockery::mock(ParameterDataProviderFactory::class);
        $factory->shouldReceive('make')->times(2)->with(Mockery::type(ReflectionParameter::class))->andReturn(Mockery::mock(ParameterDataProvider::class));

        $reflectionClass = new ReflectionClass(MockInterface::class);
        $provider = new MethodDataProvider($reflectionClass->getMethod('method1'), $factory, new AnnotationReader());
        $parameters = $provider->getParameters();

        $this->assertCount(2, $parameters);
    }

    public function testGetAnnotations()
    {
        $provider = $this->getProvider();

        $this->assertInstanceOf(MockAnnotation::class, $provider->getAnnotations()[0]);
    }

    private function getProvider()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);

        return new MethodDataProvider($reflectionClass->getMethod('method1'), Mockery::mock(ParameterDataProviderFactory::class), new AnnotationReader());
    }
}
