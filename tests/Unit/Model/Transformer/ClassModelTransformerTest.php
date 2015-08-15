<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model\Transformer;

use Mockery;
use PhpParser\Builder\Class_;
use PhpParser\Builder\Method;
use PhpParser\Builder\Namespace_;
use PhpParser\Builder\Param;
use PhpParser\Builder\Property;
use PhpParser\BuilderFactory;
use PhpParser\NodeTraverserInterface;
use PhpParser\ParserAbstract;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\ParameterModel;
use Tebru\Dynamo\Model\PropertyModel;
use Tebru\Dynamo\Model\Transformer\ClassModelTransformer;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ClassModelTransformerTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelTransformerTest extends MockeryTestCase
{
    const CLASS_NAMESPACE = 'Tebru\\Prefix\\Tebru\\Foo';
    const CLASS_INTERFACE = '\\Test\\Original\\Interface';
    const CLASS_NAME = 'TestClass';
    const CLASS_PROPERTY = 'testProperty';
    const CLASS_METHOD = 'testMethod';
    const METHOD_PARAMETER = 'testParameter';

    protected function setUp()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    public function testCanCreateTransformer()
    {
        $builderFactory = Mockery::mock(BuilderFactory::class);
        $parser = Mockery::mock(ParserAbstract::class);
        $traverser = Mockery::mock(NodeTraverserInterface::class);
        $transformer = new ClassModelTransformer($builderFactory, $parser, $traverser);

        $this->assertInstanceOf(ClassModelTransformer::class, $transformer);
    }

    /**
     * @dataProvider visibilityDataProvider
     */
    public function testCanTransform($visibility, $visibilityMethod)
    {
        $classMock = $this->getClassModelMock($visibility);
        $transformer = $this->getTransformer($visibilityMethod);
        $result = $transformer->transform($classMock);

        $this->assertSame([['']], $result);
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Property visibility must be public, protected, private
     */
    public function testThrowsException()
    {
        $classModel = Mockery::mock(ClassModel::class);
        $propertyModel = Mockery::mock(PropertyModel::class);
        $builderFactory = Mockery::mock(BuilderFactory::class);
        $parser = Mockery::mock(ParserAbstract::class);
        $traverser = Mockery::mock(NodeTraverserInterface::class);
        $namespace = Mockery::mock(Namespace_::class);
        $class = Mockery::mock(Class_::class);
        $property = Mockery::mock(Property::class);

        $classModel->shouldReceive('getNamespace')->times(1)->withNoArgs()->andReturn(self::CLASS_NAMESPACE);
        $classModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn(self::CLASS_NAME);
        $classModel->shouldReceive('getInterface')->times(1)->withNoArgs()->andReturn(self::CLASS_INTERFACE);
        $classModel->shouldReceive('getProperties')->times(1)->withNoArgs()->andReturn([$propertyModel]);
        $propertyModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testProperty');
        $propertyModel->shouldReceive('getDefaultValue')->times(1)->withNoArgs()->andReturn([]);
        $propertyModel->shouldReceive('getVisibility')->times(1)->withNoArgs()->andReturn('foo');
        $builderFactory->shouldReceive('namespace')->times(1)->with(self::CLASS_NAMESPACE)->andReturn($namespace);
        $builderFactory->shouldReceive('class')->times(1)->with(self::CLASS_NAME)->andReturn($class);
        $builderFactory->shouldReceive('property')->times(1)->with(self::CLASS_PROPERTY)->andReturn($property);
        $class->shouldReceive('implement')->times(1)->with(self::CLASS_INTERFACE)->andReturnNull();
        $property->shouldReceive('setDefault')->times(1)->with([])->andReturnNull();


        $transformer = new ClassModelTransformer($builderFactory, $parser, $traverser);
        $transformer->transform($classModel);
    }

    private function getTransformer($visibilityMethod)
    {
        $builderFactory = Mockery::mock(BuilderFactory::class);
        $parser = Mockery::mock(ParserAbstract::class);
        $traverser = Mockery::mock(NodeTraverserInterface::class);
        $namespace = Mockery::mock(Namespace_::class);
        $class = Mockery::mock(Class_::class);
        $property = Mockery::mock(Property::class);
        $method = Mockery::mock(Method::class);
        $parameter = Mockery::mock(Param::class);

        $builderFactory->shouldReceive('namespace')->times(1)->with(self::CLASS_NAMESPACE)->andReturn($namespace);
        $builderFactory->shouldReceive('class')->times(1)->with(self::CLASS_NAME)->andReturn($class);
        $builderFactory->shouldReceive('property')->times(1)->with(self::CLASS_PROPERTY)->andReturn($property);
        $builderFactory->shouldReceive('method')->times(1)->with(self::CLASS_METHOD)->andReturn($method);
        $builderFactory->shouldReceive('param')->times(1)->with(self::METHOD_PARAMETER)->andReturn($parameter);
        $class->shouldReceive('implement')->times(1)->with(self::CLASS_INTERFACE)->andReturnNull();
        $class->shouldReceive('addStmt')->times(1)->with($method)->andReturnNull();
        $property->shouldReceive('setDefault')->times(1)->with([])->andReturnNull();
        $property->shouldReceive($visibilityMethod)->times(1)->withNoArgs()->andReturnNull();
        $parser->shouldReceive('parse')->times(1)->with('$x = 1;')->andReturn(['']);
        $traverser->shouldReceive('traverse')->times(1)->with([''])->andReturn(['']);
        $method->shouldReceive('makePublic')->times(1)->withNoArgs()->andReturnNull();
        $method->shouldReceive('addStmts')->times(1)->with([''])->andReturnNull();
        $method->shouldReceive('addParam')->times(1)->with($parameter)->andReturnNull();
        $parameter->shouldReceive('setTypeHint')->times(1)->with('array')->andReturnNull();
        $parameter->shouldReceive('setDefault')->times(1)->with([])->andReturnNull();
        $namespace->shouldReceive('addStmt')->times(1)->with($class)->andReturnNull();
        $namespace->shouldReceive('getNode')->times(1)->withNoArgs()->andReturn(['']);

        return new ClassModelTransformer($builderFactory, $parser, $traverser);
    }

    private function getClassModelMock($visibilty)
    {
        $classModel = Mockery::mock(ClassModel::class);
        $propertyModel = Mockery::mock(PropertyModel::class);
        $methodModel = Mockery::mock(MethodModel::class);
        $parameterModel = Mockery::mock(ParameterModel::class);

        $classModel->shouldReceive('getNamespace')->times(1)->withNoArgs()->andReturn(self::CLASS_NAMESPACE);
        $classModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn(self::CLASS_NAME);
        $classModel->shouldReceive('getInterface')->times(1)->withNoArgs()->andReturn(self::CLASS_INTERFACE);
        $classModel->shouldReceive('getProperties')->times(1)->withNoArgs()->andReturn([$propertyModel]);
        $classModel->shouldReceive('getMethods')->times(1)->withNoArgs()->andReturn([$methodModel]);
        $propertyModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testProperty');
        $propertyModel->shouldReceive('getDefaultValue')->times(1)->withNoArgs()->andReturn([]);
        $propertyModel->shouldReceive('getVisibility')->times(1)->withNoArgs()->andReturn($visibilty);
        $methodModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testMethod');
        $methodModel->shouldReceive('getBody')->times(1)->withNoArgs()->andReturn('$x = 1;');
        $methodModel->shouldReceive('getParameters')->times(1)->withNoArgs()->andReturn([$parameterModel]);
        $parameterModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn('testParameter');
        $parameterModel->shouldReceive('hasTypeHint')->times(1)->withNoArgs()->andReturn(true);
        $parameterModel->shouldReceive('getTypeHint')->times(1)->withNoArgs()->andReturn('array');
        $parameterModel->shouldReceive('isOptional')->times(1)->withNoArgs()->andReturn(true);
        $parameterModel->shouldReceive('getDefaultValue')->times(1)->withNoArgs()->andReturn([]);

        return $classModel;
    }

    public function visibilityDataProvider()
    {
        return [
            ['public', 'makePublic'],
            ['protected', 'makeProtected'],
            ['private', 'makePrivate'],
        ];
    }
}
