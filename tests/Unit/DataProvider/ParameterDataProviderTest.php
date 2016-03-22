<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use Mockery;
use ReflectionClass;
use ReflectionParameter;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Mock\MockReflectionParameter;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ParameterDataProviderTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterDataProviderTest extends MockeryTestCase
{
    public function testCanCreateNewParameterDataProvider()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertInstanceOf(ParameterDataProvider::class, $provider);
    }

    public function testGetTypeHintClass()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('\\Tebru\\Dynamo\\Test\\Mock\\MockClass', $provider->getTypeHint());
    }

    public function testGetTypeHintArray()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('array', $provider->getTypeHint());
    }

    public function testGetTypeHintCallable()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method2');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('callable', $provider->getTypeHint());
    }

    public function testGetTypeHintFromType()
    {
        $reflectionParameter = Mockery::mock(MockReflectionParameter::class);
        $reflectionParameter->shouldReceive('getClass')->times(1)->withNoArgs()->andReturnNull();
        $reflectionParameter->shouldReceive('isArray')->times(1)->withNoArgs()->andReturn(false);
        $reflectionParameter->shouldReceive('isCallable')->times(1)->withNoArgs()->andReturn(false);
        $reflectionParameter->shouldReceive('getType')->times(2)->withNoArgs()->andReturn('int');
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('int', $provider->getTypeHint());
    }

    public function testGetTypeHintNone()
    {
        $reflectionParameter = Mockery::mock(MockReflectionParameter::class);
        $reflectionParameter->shouldReceive('getClass')->times(1)->withNoArgs()->andReturnNull();
        $reflectionParameter->shouldReceive('isArray')->times(1)->withNoArgs()->andReturn(false);
        $reflectionParameter->shouldReceive('isCallable')->times(1)->withNoArgs()->andReturn(false);
        $reflectionParameter->shouldReceive('getType')->times(1)->withNoArgs()->andReturnNull();
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('', $provider->getTypeHint());
    }

    public function testGetName()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('arg1', $provider->getName());
    }

    public function testHasDefaultValueNull()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertTrue($provider->hasDefaultValue());
    }

    public function testHasDefaultValueScalar()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertTrue($provider->hasDefaultValue());
    }

    public function testNotHasDefaultValue()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertFalse($provider->hasDefaultValue());
    }

    public function testGetDefaultValueNull()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParameter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame(null, $provider->getDefaultValue());
    }

    public function testGetDefaultValueInt()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParameter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame(1, $provider->getDefaultValue());
    }

    public function testGetDefaultValueString()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParameter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('test', $provider->getDefaultValue());
    }

    public function testGetDefaultValueBool()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParameter = $reflectionMethod->getParameters()[2];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame(false, $provider->getDefaultValue());
    }

    public function testGetDefaultValueArray()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParameter = $reflectionMethod->getParameters()[3];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame([], $provider->getDefaultValue());
    }

    public function testGetDefaultValueConst()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method2');
        $reflectionParameter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParameter);

        $this->assertSame('const2', $provider->getDefaultValue());
    }
}
