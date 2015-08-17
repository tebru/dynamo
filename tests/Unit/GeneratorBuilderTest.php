<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit;

use Doctrine\Common\Annotations\Reader;
use Mockery;
use PhpParser\BuilderFactory;
use PhpParser\Lexer;
use PhpParser\NodeTraverserInterface;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserAbstract;
use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Tebru\Dynamo\Cache\ClassModelCacher;
use Tebru\Dynamo\DataProvider\Factory\AnnotationDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\InterfaceDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;
use Tebru\Dynamo\Generator;
use Tebru\Dynamo\Model\Factory\ClassModelFactory;
use Tebru\Dynamo\Model\Factory\MethodModelFactory;
use Tebru\Dynamo\Model\Factory\ParameterModelFactory;
use Tebru\Dynamo\Model\Transformer\ClassModelTransformer;

/**
 * Class GeneratorBuilderTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class GeneratorBuilderTest extends MockeryTestCase
{
    public function testWillCreateGeneratorWithDefaults()
    {
        $generator = Generator::builder()->build();

        $this->assertInstanceOf(Generator::class, $generator);
    }

    public function testCanUseAllSetters()
    {
        $namespacePrefix = 'Tebru\\Test';
        $parameterDataProviderFactory = Mockery::mock(ParameterDataProviderFactory::class);
        $reader = Mockery::mock(Reader::class);
        $annotationDataProviderFactory = Mockery::mock(AnnotationDataProviderFactory::class);
        $methodDataProviderFactory = Mockery::mock(MethodDataProviderFactory::class);
        $interfaceDataProviderFactory = Mockery::mock(InterfaceDataProviderFactory::class);
        $parameterModelFactory = Mockery::mock(ParameterModelFactory::class);
        $methodModelFactory = Mockery::mock(MethodModelFactory::class);
        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $classModelFactory = Mockery::mock(ClassModelFactory::class);
        $cacheDir = '';
        $filesystem = Mockery::mock(Filesystem::class);
        $builderFactory = Mockery::mock(BuilderFactory::class);
        $lexer = Mockery::mock(Lexer::class);
        $parser = Mockery::mock(ParserAbstract::class);
        $traverser = Mockery::mock(NodeTraverserInterface::class);
        $classModelTransformer = Mockery::mock(ClassModelTransformer::class);
        $printer = Mockery::mock(PrettyPrinterAbstract::class);
        $classModelCacher = Mockery::mock(ClassModelCacher::class);

        $traverser->shouldReceive('addVisitor')->with(Mockery::type(NameResolver::class))->andReturnNull();

        $generator = Generator::builder()
            ->setNamespacePrefix($namespacePrefix)
            ->setParameterDataProviderFactory($parameterDataProviderFactory)
            ->setReader($reader)
            ->setAnnotationDataProviderFactory($annotationDataProviderFactory)
            ->setMethodDataProviderFactory($methodDataProviderFactory)
            ->setInterfaceDataProviderFactory($interfaceDataProviderFactory)
            ->setParameterModelFactory($parameterModelFactory)
            ->setMethodModelFactory($methodModelFactory)
            ->setEventDispatcher($eventDispatcher)
            ->setClassModelFactory($classModelFactory)
            ->setCacheDir($cacheDir)
            ->setFilesystem($filesystem)
            ->setBuilderFactory($builderFactory)
            ->setLexer($lexer)
            ->setParser($parser)
            ->setTraverser($traverser)
            ->setClassModelTransformer($classModelTransformer)
            ->setPrinter($printer)
            ->setClassModelCacher($classModelCacher)
            ->build();

        $this->assertInstanceOf(Generator::class, $generator);
    }
}
