<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Model;

use PHPUnit_Framework_TestCase;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\PropertyModel;

/**
 * Class PropertyModelTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class PropertyModelTest extends PHPUnit_Framework_TestCase
{
    public function testCanCreatePropertyModel()
    {
        $propertyModel = $this->getPropertyModel();

        $this->assertInstanceOf(PropertyModel::class, $propertyModel);
    }

    public function testCanGetClassModel()
    {
        $propertyModel = $this->getPropertyModel();

        $this->assertInstanceOf(ClassModel::class, $propertyModel->getClassModel());
    }

    public function testCanGetName()
    {
        $propertyModel = $this->getPropertyModel();

        $this->assertSame('property1', $propertyModel->getName());
    }

    public function testCanSetName()
    {
        $propertyModel = $this->getPropertyModel();
        $propertyModel->setName('property2');

        $this->assertSame('property2', $propertyModel->getName());
    }

    public function testCanGetVisibility()
    {
        $propertyModel = $this->getPropertyModel();

        $this->assertSame('private', $propertyModel->getVisibility());
    }

    public function testCanSetVisibility()
    {
        $propertyModel = $this->getPropertyModel();
        $propertyModel->setVisibility(PropertyModel::VISIBILITY_PROTECTED);

        $this->assertSame('protected', $propertyModel->getVisibility());
    }

    public function testCanGetDefaultValue()
    {
        $propertyModel = $this->getPropertyModel();
        $propertyModel->setDefaultValue(1);

        $this->assertSame(1, $propertyModel->getDefaultValue());
    }

    public function testCanSetDefaultValue()
    {
        $propertyModel = $this->getPropertyModel();
        $propertyModel->setDefaultValue(1);

        $this->assertAttributeEquals(1, 'defaultValue', $propertyModel);
    }


    private function getPropertyModel()
    {
        $classModel = new ClassModel('My\\Namespace', 'MyClass', '\\My\\Interface\\ClassName');

        return new PropertyModel($classModel, 'property1');
    }
}
