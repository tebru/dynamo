<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Cache;

use Mockery;
use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\Filesystem\Filesystem;
use Tebru\Dynamo\Cache\ClassModelCacher;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\Transformer\ClassModelTransformer;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class ClassModelCacherTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelCacherTest extends MockeryTestCase
{
    public function testCanCreateCacher()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $classModelTransformer = Mockery::mock(ClassModelTransformer::class);
        $printer = Mockery::mock(PrettyPrinterAbstract::class);
        $cacher = new ClassModelCacher('', $filesystem, $classModelTransformer, $printer);

        $this->assertInstanceOf(ClassModelCacher::class, $cacher);
    }

    public function testWrite()
    {
        $cacheDir = 'cache/dynamo';
        $interface = '\\' . MockInterface::class;
        $className = 'Foo';
        $path = "$cacheDir/Tebru/Dynamo/Test/Mock";
        $filename = "$path/$className.php";

        $filesystem = Mockery::mock(Filesystem::class);
        $classModelTransformer = Mockery::mock(ClassModelTransformer::class);
        $printer = Mockery::mock(PrettyPrinterAbstract::class);
        $classModel = Mockery::mock(ClassModel::class);

        $filesystem->shouldReceive('mkdir')->times(1)->with($path)->andReturnNull();
        $filesystem->shouldReceive('dumpFile')->times(1)->with($filename, 'content');
        $classModelTransformer->shouldReceive('transform')->times(1)->with($classModel)->andReturn(['']);
        $printer->shouldReceive('prettyPrintFile')->times(1)->with([''])->andReturn('content');
        $classModel->shouldReceive('getInterface')->times(1)->withNoArgs()->andReturn($interface);
        $classModel->shouldReceive('getName')->times(1)->withNoArgs()->andReturn($className);

        $cacher = new ClassModelCacher($cacheDir, $filesystem, $classModelTransformer, $printer);
        $cacher->write($classModel);
    }
}
