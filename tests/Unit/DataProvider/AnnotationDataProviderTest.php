<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use Doctrine\Common\Annotations\Reader;
use Mockery;
use ReflectionClass;
use ReflectionMethod;
use stdClass;
use Tebru\Dynamo\DataProvider\AnnotationDataProvider;
use Tebru\Dynamo\Test\Mock\Annotation\MockAnnotationInterface;
use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockAnnotation2;
use Tebru\Dynamo\Test\Mock\MockAnnotation3;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class AnnotationDataProviderTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationDataProviderTest extends MockeryTestCase
{
    public function testCanCreateProvider()
    {
        $provider = new AnnotationDataProvider(Mockery::mock(Reader::class), Mockery::mock(ReflectionMethod::class));

        $this->assertInstanceOf(AnnotationDataProvider::class, $provider);
    }

    public function testGetAnnotations()
    {
        $reflectionClass = new ReflectionClass(MockAnnotationInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method');

        $reader = Mockery::mock(Reader::class);

        $reader->shouldReceive('getMethodAnnotations')->times(1)->with($reflectionMethod)->andReturn([new MockAnnotation(), new stdClass()]);
        $reader->shouldReceive('getClassAnnotations')->times(1)->with(Mockery::type(ReflectionClass::class))->andReturn([]);
        $reader->shouldReceive('getMethodAnnotations')->times(1)->with(Mockery::type(ReflectionMethod::class))->andReturn([new MockAnnotation(), new MockAnnotation2()]);
        $reader->shouldReceive('getClassAnnotations')->times(1)->with(Mockery::type(ReflectionClass::class))->andReturn([new MockAnnotation()]);
        $reader->shouldReceive('getClassAnnotations')->times(1)->with(Mockery::type(ReflectionClass::class))->andReturn([new MockAnnotation3()]);

        $provider = new AnnotationDataProvider($reader, $reflectionMethod);
        $annotations = $provider->getAnnotations();

        $this->assertEquals(['mock' => [new MockAnnotation()], 'mock2' => new MockAnnotation2(), 'mock3' => [new MockAnnotation3()]], $annotations->getAnnotations());
    }
}
