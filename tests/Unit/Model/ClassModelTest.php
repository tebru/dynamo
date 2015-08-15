<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model;

use PHPUnit_Framework_TestCase;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\PropertyModel;

/**
 * Class ClassModelTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateClassModel()
    {
        $classModel = $this->getClassModel();

        $this->assertInstanceOf(ClassModel::class, $classModel);
    }

    public function testCanGetNamespace()
    {
        $classModel = $this->getClassModel();

        $this->assertSame('My\\Namespace', $classModel->getNamespace());
    }

    public function testCanSetNamespace()
    {
        $classModel = $this->getClassModel();
        $classModel->setNamespace('My\\Namespace2');

        $this->assertSame('My\\Namespace2', $classModel->getNamespace());
    }

    public function testCanGetName()
    {
        $classModel = $this->getClassModel();

        $this->assertSame('MyClass', $classModel->getName());
    }

    public function testCanSetName()
    {
        $classModel = $this->getClassModel();
        $classModel->setName('MyClass2');

        $this->assertSame('MyClass2', $classModel->getName());
    }

    public function testCanGetFullName()
    {
        $classModel = $this->getClassModel();

        $this->assertSame('My\\Namespace\\MyClass', $classModel->getFullName());
    }

    public function testCanGetInterface()
    {
        $classModel = $this->getClassModel();

        $this->assertSame('\\My\\Interface\\ClassName', $classModel->getInterface());
    }

    public function testCanAddMethod()
    {
        $classModel = $this->getClassModel();
        $methodModel = new MethodModel($classModel, 'method1');
        $classModel->addMethod($methodModel);

        $this->assertAttributeCount(1, 'methods', $classModel);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method "method1" already exists on class
     */
    public function testAddMethodThatAlreadyExistsThrowsException()
    {
        $classModel = $this->getClassModel();
        $methodModel = new MethodModel($classModel, 'method1');
        $classModel->addMethod($methodModel);
        $classModel->addMethod($methodModel);

        $this->assertAttributeEquals([$methodModel], 'methods', $classModel);
    }

    public function testCanRemoveMethod()
    {
        $classModel = $this->getClassModel();
        $methodModel = new MethodModel($classModel, 'method1');
        $classModel->addMethod($methodModel);
        $classModel->removeMethod($methodModel);

        $this->assertAttributeCount(0, 'methods', $classModel);
    }

    public function testCanGetMethod()
    {
        $classModel = $this->getClassModel();
        $methodModel = new MethodModel($classModel, 'method1');
        $classModel->addMethod($methodModel);
        $fetchedMethod = $classModel->getMethod('method1');

        $this->assertSame($methodModel, $fetchedMethod);
    }

    public function testCanGetMethods()
    {
        $classModel = $this->getClassModel();
        $methodModel = new MethodModel($classModel, 'method1');
        $classModel->addMethod($methodModel);
        $fetchedMethods = $classModel->getMethods();

        $this->assertSame([$methodModel->getName() => $methodModel], $fetchedMethods);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method "method1" does not exist on class
     */
    public function testGetMethodWillThrowException()
    {
        $classModel = $this->getClassModel();
        $classModel->getMethod('method1');
    }

    public function testCanAddProperty()
    {
        $classModel = $this->getClassModel();
        $propertyModel = new PropertyModel($classModel, 'property1');
        $classModel->addProperty($propertyModel);

        $this->assertAttributeCount(1, 'properties', $classModel);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Property "property1" already exists on class
     */
    public function testAddPropertyThatAlreadyExistsThrowsException()
    {
        $classModel = $this->getClassModel();
        $propertyModel = new PropertyModel($classModel, 'property1');
        $classModel->addProperty($propertyModel);
        $classModel->addProperty($propertyModel);

        $this->assertAttributeEquals([$propertyModel], 'properties', $classModel);
    }

    public function testCanRemoveProperty()
    {
        $classModel = $this->getClassModel();
        $propertyModel = new PropertyModel($classModel, 'property1');
        $classModel->addProperty($propertyModel);
        $classModel->removeProperty($propertyModel);

        $this->assertAttributeCount(0, 'properties', $classModel);
    }

    public function testCanGetProperty()
    {
        $classModel = $this->getClassModel();
        $propertyModel = new PropertyModel($classModel, 'property1');
        $classModel->addProperty($propertyModel);
        $fetchedProperty = $classModel->getProperty('property1');

        $this->assertSame($propertyModel, $fetchedProperty);
    }

    public function testCanGetProperties()
    {
        $classModel = $this->getClassModel();
        $propertyModel = new PropertyModel($classModel, 'property1');
        $classModel->addProperty($propertyModel);
        $fetchedProperties = $classModel->getProperties();

        $this->assertSame([$propertyModel->getName() => $propertyModel], $fetchedProperties);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Property "property1" does not exist on class
     */
    public function testGetPropertyWillThrowException()
    {
        $classModel = $this->getClassModel();
        $classModel->getProperty('property1');
    }

    private function getClassModel()
    {
        return new ClassModel('My\\Namespace', 'MyClass', '\\My\\Interface\\ClassName');
    }
}
