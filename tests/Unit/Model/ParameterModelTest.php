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
use Tebru\Dynamo\Test\Mock\MockInterface;

/**
 * Class ParameterModelTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterModelTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreateParameterModel()
    {
        $parameterModel = $this->getParamterModel();

        $this->assertInstanceOf(ParameterModel::class, $parameterModel);
    }

    public function testCanGetClassModel()
    {
        $parameterModel = $this->getParamterModel();

        $this->assertInstanceOf(MethodModel::class, $parameterModel->getMethodModel());
    }

    public function testCanGetName()
    {
        $parameterModel = $this->getParamterModel();

        $this->assertSame('parameter1', $parameterModel->getName());
    }

    public function testCanSetName()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setName('parameter2');

        $this->assertSame('parameter2', $parameterModel->getName());
    }

    public function testIsNotOptional()
    {
        $parameterModel = $this->getParamterModel();

        $this->assertFalse($parameterModel->isOptional());
    }

    public function testIsOptional()
    {
        $parameterModel = $this->getParamterModel(true);

        $this->assertTrue($parameterModel->isOptional());
    }

    public function testSetOptional()
    {
        $parameterModel = $this->getParamterModel(true);
        $parameterModel->setOptional(false);

        $this->assertFalse($parameterModel->isOptional());
    }

    public function testSetTypehint()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('array');

        $this->assertAttributeSame('array', 'typeHint', $parameterModel);
    }

    public function testGetTypehint()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('array');

        $this->assertSame('array', $parameterModel->getTypeHint());
    }

    public function testNotHasTypehint()
    {
        $parameterModel = $this->getParamterModel();

        $this->assertFalse($parameterModel->hasTypeHint());
    }

    public function testHasTypehint()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('array');

        $this->assertTrue($parameterModel->hasTypeHint());
    }

    public function testIsArray()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('array');

        $this->assertTrue($parameterModel->isArray());
    }

    public function testIsCallable()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('callable');

        $this->assertTrue($parameterModel->isCallable());
    }

    public function testIsObject()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setTypeHint('\\' . MockInterface::class);

        $this->assertTrue($parameterModel->isObject());
    }

    public function testSetDefaultValue()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setDefaultValue('array');

        $this->assertAttributeSame('array', 'defaultValue', $parameterModel);
    }

    public function testGetDefaultValue()
    {
        $parameterModel = $this->getParamterModel();
        $parameterModel->setDefaultValue([]);

        $this->assertSame([], $parameterModel->getDefaultValue());
    }

    private function getParamterModel($optional = false)
    {
        $classModel = new ClassModel('My\\Namespace', 'MyClass', '\\My\\Interface\\ClassName');
        $methodModel = new MethodModel($classModel, 'method1');

        return new ParameterModel($methodModel, 'parameter1', $optional);
    }
}
