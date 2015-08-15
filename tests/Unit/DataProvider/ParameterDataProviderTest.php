<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use ReflectionClass;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Test\Mock\MockInterface;
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
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertInstanceOf(ParameterDataProvider::class, $provider);
    }

    public function testGetTypeHintClass()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('\\Tebru\\Dynamo\\Test\\Mock\\MockClass', $provider->getTypeHint());
    }

    public function testGetTypeHintArray()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('array', $provider->getTypeHint());
    }

    public function testGetTypeHintCallable()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method2');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('callable', $provider->getTypeHint());
    }

    public function testGetTypeHintNone()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('', $provider->getTypeHint());
    }

    public function testGetName()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('arg1', $provider->getName());
    }

    public function testHasDefaultValueNull()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertTrue($provider->hasDefaultValue());
    }

    public function testHasDefaultValueScalar()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertTrue($provider->hasDefaultValue());
    }

    public function testNotHasDefaultValue()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertFalse($provider->hasDefaultValue());
    }

    public function testGetDefaultValueNull()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method1');
        $reflectionParamter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame(null, $provider->getDefaultValue());
    }

    public function testGetDefaultValueInt()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[0];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame(1, $provider->getDefaultValue());
    }

    public function testGetDefaultValueString()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('test', $provider->getDefaultValue());
    }

    public function testGetDefaultValueBool()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[2];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame(false, $provider->getDefaultValue());
    }

    public function testGetDefaultValueArray()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method3');
        $reflectionParamter = $reflectionMethod->getParameters()[3];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame([], $provider->getDefaultValue());
    }

    public function testGetDefaultValueConst()
    {
        $reflectionClass = new ReflectionClass(MockInterface::class);
        $reflectionMethod = $reflectionClass->getMethod('method2');
        $reflectionParamter = $reflectionMethod->getParameters()[1];
        $provider = new ParameterDataProvider($reflectionParamter);

        $this->assertSame('const2', $provider->getDefaultValue());
    }
}
