<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model\Factory;

use Mockery;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tebru\Dynamo\DataProvider\Factory\InterfaceDataProviderFactory;
use Tebru\Dynamo\DataProvider\InterfaceDataProvider;
use Tebru\Dynamo\DataProvider\MethodDataProvider;
use Tebru\Dynamo\Event\EndEvent;
use Tebru\Dynamo\Event\MethodEvent;
use Tebru\Dynamo\Event\StartEvent;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\Factory\ClassModelFactory;
use Tebru\Dynamo\Model\Factory\MethodModelFactory;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ClassModelFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelFactoryTest extends MockeryTestCase
{
    public function testCanCreateClassModelFactory()
    {
        $factory = $this->getFactory(false);

        $this->assertInstanceOf(ClassModelFactory::class, $factory);
    }

    public function testCanCreateClassModel()
    {
        $factory = $this->getFactory();
        $classModel = $factory->make(MockInterface::class);

        $this->assertInstanceOf(ClassModel::class, $classModel);
        $this->assertSame('Tebru\\Foo\\Tebru\\Namespace\\ClassName', $classModel->getFullName());
        $this->assertSame('\\Tebru\\Dynamo\\Test\\Mock\\MockInterface', $classModel->getInterface());
        $this->assertCount(1, $classModel->getMethods());
    }

    private function getFactory($shouldStub = true, $interfaceName = MockInterface::class)
    {
        $interfaceDataProviderFactory = Mockery::mock(InterfaceDataProviderFactory::class);
        $methodModelFactory = Mockery::mock(MethodModelFactory::class);
        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $interfaceDataProvider = Mockery::mock(InterfaceDataProvider::class);
        $methodDataProvider = Mockery::mock(MethodDataProvider::class);
        $methodModel = Mockery::mock(MethodModel::class);

        $classAnnotations = [MockAnnotation::class => new MockAnnotation()];
        $methodAnnotations = [MockAnnotation::class => new MockAnnotation()];

        if ($shouldStub) {
            $interfaceDataProviderFactory->shouldReceive('make')->times(1)->with($interfaceName)->andReturn($interfaceDataProvider);
            $interfaceDataProvider->shouldReceive('getAnnotations')->times(1)->withNoArgs()->andReturn($classAnnotations);
            $interfaceDataProvider->shouldReceive('getNamespace')->times(1)->withNoArgs()->andReturn('Tebru\\Namespace');
            $interfaceDataProvider->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('ClassName');
            $interfaceDataProvider->shouldReceive('getFullName')->times(1)->withNoArgs()->andReturn('\\' . MockInterface::class);
            $interfaceDataProvider->shouldReceive('getMethods')->times(1)->withNoArgs()->andReturn([$methodDataProvider]);
            $methodModelFactory->shouldReceive('make')->times(1)->with(Mockery::type(ClassModel::class), $methodDataProvider)->andReturn($methodModel);
            $methodDataProvider->shouldReceive('getAnnotations')->times(1)->withNoArgs()->andReturn($methodAnnotations);
            $eventDispatcher->shouldReceive('dispatch')->times(1)->with(StartEvent::NAME, Mockery::type(StartEvent::class))->andReturnNull();
            $eventDispatcher->shouldReceive('dispatch')->times(1)->with(MethodEvent::NAME, Mockery::type(MethodEvent::class))->andReturnNull();
            $eventDispatcher->shouldReceive('dispatch')->times(1)->with(EndEvent::NAME, Mockery::type(EndEvent::class))->andReturnNull();
            $methodModel->shouldReceive('getName')->times(2)->withNoArgs()->andReturn('testMethod');
        }

        return new ClassModelFactory(
            'Tebru\\Foo',
            $interfaceDataProviderFactory,
            $methodModelFactory,
            $eventDispatcher
        );
    }
}
