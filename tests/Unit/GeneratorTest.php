<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit;

use Mockery;
use Tebru\Dynamo\Cache\ClassModelCacher;
use Tebru\Dynamo\Generator;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\Factory\ClassModelFactory;

/**
 * Class GeneratorTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class GeneratorTest extends MockeryTestCase
{
    public function testCanCreateGenerator()
    {
        $classModelFactory = Mockery::mock(ClassModelFactory::class);
        $classModelCacher = Mockery::mock(ClassModelCacher::class);
        $generator = new Generator($classModelFactory, $classModelCacher);

        $this->assertInstanceOf(Generator::class, $generator);
    }

    public function testCanGenerate()
    {
        $classModelFactory = Mockery::mock(ClassModelFactory::class);
        $classModelCacher = Mockery::mock(ClassModelCacher::class);
        $classModel = Mockery::mock(ClassModel::class);

        $classModelFactory->shouldReceive('make')->times(1)->with('Foo')->andReturn($classModel);
        $classModelCacher->shouldReceive('write')->times(1)->with($classModel)->andReturnNull();

        $generator = new Generator($classModelFactory, $classModelCacher);
        $result = $generator->createAndWrite('Foo');

        $this->assertInstanceOf(Generator::class, $generator);

    }
}
