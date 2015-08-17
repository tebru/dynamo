<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model;

use PHPUnit_Framework_TestCase;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\ParameterModel;

/**
 * Class MethodModelTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodModelTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateMethodModel()
    {
        $methodModel = $this->getMethodModel();

        $this->assertInstanceOf(MethodModel::class, $methodModel);
    }

    public function testCanGetClassModel()
    {
        $methodModel = $this->getMethodModel();

        $this->assertInstanceOf(ClassModel::class, $methodModel->getClassModel());
    }

    public function testCanGetName()
    {
        $methodModel = $this->getMethodModel();

        $this->assertEquals('method1', $methodModel->getName());
    }

    public function testCanSetName()
    {
        $methodModel = $this->getMethodModel();
        $methodModel->setName('method2');

        $this->assertEquals('method2', $methodModel->getName());
    }

    public function testCanAddParameter()
    {
        $methodModel = $this->getMethodModel();
        $parameterModel = new ParameterModel($methodModel, 'parameter1', false);
        $methodModel->addParameter($parameterModel);

        $this->assertAttributeCount(1, 'parameters', $methodModel);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Parameter "parameter1" already exists in method
     */
    public function testAddParameterThatAlreadyExistsThrowsException()
    {
        $methodModel = $this->getMethodModel();
        $parameterModel = new ParameterModel($methodModel, 'parameter1', false);
        $methodModel->addParameter($parameterModel);
        $methodModel->addParameter($parameterModel);

        $this->assertAttributeEquals([$parameterModel], 'parameters', $methodModel);
    }

    public function testCanRemoveParameter()
    {
        $methodModel = $this->getMethodModel();
        $parameterModel = new ParameterModel($methodModel, 'parameter1', false);
        $methodModel->addParameter($parameterModel);
        $methodModel->removeParameter($parameterModel);

        $this->assertAttributeCount(0, 'parameters', $methodModel);
    }

    public function testCanGetParameter()
    {
        $methodModel = $this->getMethodModel();
        $parameterModel = new ParameterModel($methodModel, 'parameter1', false);
        $methodModel->addParameter($parameterModel);
        $fetchedParameter = $methodModel->getParameter('parameter1');

        $this->assertSame($parameterModel, $fetchedParameter);
    }

    public function testCanGetParameters()
    {
        $methodModel = $this->getMethodModel();
        $parameterModel = new ParameterModel($methodModel, 'parameter1', false);
        $methodModel->addParameter($parameterModel);
        $fetchedParameters = $methodModel->getParameters();

        $this->assertSame([$parameterModel->getName() => $parameterModel], $fetchedParameters);
    }

    /**
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Parameter "parameter1" does not exist in method
     */
    public function testGetParameterWillThrowException()
    {
        $methodModel = $this->getMethodModel();
        $methodModel->getParameter('parameter1');
    }

    public function testCanSetBody()
    {
        $methodModel = $this->getMethodModel();
        $methodModel->setBody('$x = 1;');

        $this->assertAttributeEquals('$x = 1;', 'body', $methodModel);
    }

    public function testCanGetBody()
    {
        $methodModel = $this->getMethodModel();
        $methodModel->setBody('$x = 1;');

        $this->assertSame('$x = 1;', $methodModel->getBody());

    }

    private function getMethodModel()
    {
        $classModel = new ClassModel('My\\Namespace', 'MyClass', '\\My\\Interface\\ClassName');

        return new MethodModel($classModel, 'method1');
    }
}
