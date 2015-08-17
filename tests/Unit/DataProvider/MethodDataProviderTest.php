<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use Doctrine\Common\Annotations\Annotation;
use Mockery;
use ReflectionClass;
use ReflectionParameter;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\DataProvider\AnnotationDataProvider;
use Tebru\Dynamo\DataProvider\Factory\AnnotationDataProviderFactory;
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
        $parameterDataProviderFactory = Mockery::mock(ParameterDataProviderFactory::class);
        $parameterDataProvider = Mockery::mock(ParameterDataProvider::class);
        $annotationDataProviderFactory = Mockery::mock(AnnotationDataProviderFactory::class);
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');

        $parameterDataProviderFactory->shouldReceive('make')->times(2)->with(Mockery::type(ReflectionParameter::class))->andReturn($parameterDataProvider);

        $provider = new MethodDataProvider($reflectionMethod, $parameterDataProviderFactory, $annotationDataProviderFactory);
        $parameters = $provider->getParameters();

        $this->assertCount(2, $parameters);
    }

    public function testGetAnnotations()
    {
        $parameterDataProviderFactory = Mockery::mock(ParameterDataProviderFactory::class);
        $annotationDataProviderFactory = Mockery::mock(AnnotationDataProviderFactory::class);
        $annotationDataProvider = Mockery::mock(AnnotationDataProvider::class);
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');

        $annotationDataProviderFactory->shouldReceive('make')->times(1)->with($reflectionMethod)->andReturn($annotationDataProvider);
        $annotationDataProvider->shouldReceive('getAnnotations')->times(1)->withNoArgs()->andReturn(new AnnotationCollection());

        $provider = new MethodDataProvider($reflectionMethod, $parameterDataProviderFactory, $annotationDataProviderFactory);

        $this->assertInstanceOf(AnnotationCollection::class, $provider->getAnnotations());
    }

    private function getProvider()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);

        return new MethodDataProvider($reflectionClass->getMethod('method1'), Mockery::mock(ParameterDataProviderFactory::class), Mockery::mock(AnnotationDataProviderFactory::class));
    }
}
