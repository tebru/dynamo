<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider;

use Doctrine\Common\Annotations\AnnotationReader;
use Mockery;
use ReflectionMethod;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;
use Tebru\Dynamo\DataProvider\InterfaceDataProvider;
use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Mock\Parent\Parent\MockParentParentInterface;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class InterfaceDataProviderTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class InteraceDataProviderTest extends MockeryTestCase
{
    public function testCanCreateProvider()
    {
        $provider = $this->getProvider();

        $this->assertInstanceOf(InterfaceDataProvider::class, $provider);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage "Foo" is not a valid interface
     */
    public function testWillThrowExceptionIfInterfaceNotExists()
    {
        $this->getProvider('Foo');
    }

    public function testGetFilename()
    {
        $provider = $this->getProvider();

        $this->assertTrue(file_exists($provider->getFilename()));
    }

    public function testGetNamespace()
    {
        $provider = $this->getProvider();

        $this->assertSame('Tebru\\Dynamo\\Test\\Mock', $provider->getNamespace());
    }

    public function testGetInterfaceName()
    {
        $provider = $this->getProvider();

        $this->assertSame('MockInterface', $provider->getName());
    }

    public function testGetFullInterfaceName()
    {
        $provider = $this->getProvider();

        $this->assertSame('\\Tebru\\Dynamo\\Test\\Mock\\MockInterface', $provider->getFullName());
    }

    public function testGetInterfaceParents()
    {
        $provider = $this->getProvider();

        $expected = [
            'Tebru\\Dynamo\\Test\Mock\\Parent\\MockParentInterface',
            'Tebru\\Dynamo\\Test\Mock\\Parent\\Parent\\MockParentParentInterface',
            'Tebru\\Dynamo\\Test\Mock\\Parent\\MockParentInterface2',
        ];

        $this->assertSame($expected, $provider->getParents());
    }

    public function testGetInterfaceParentsWithoutParents()
    {
        $provider = $this->getProvider(MockParentParentInterface::class);

        $this->assertSame([], $provider->getParents());
    }

    public function testGetConstants()
    {
        $provider = $this->getProvider();

        $this->assertSame(['CONST1' => 'const1', 'CONST2' => 'const2'], $provider->getConstants());
    }

    public function testGetMethods()
    {
        $factory = Mockery::mock(MethodDataProviderFactory::class);
        $factory->shouldReceive('make')->times(4)->with(Mockery::type(ReflectionMethod::class))->andReturn(Mockery::mock(MethodDataProvider::class));
        $provider = new InterfaceDataProvider(MockInterface::class, $factory, new AnnotationReader());
        $methods = $provider->getMethods();

        $this->assertCount(4, $methods);
    }

    private function getProvider($interface = MockInterface::class)
    {
        return new InterfaceDataProvider($interface, Mockery::mock(MethodDataProviderFactory::class), new AnnotationReader());
    }
}
