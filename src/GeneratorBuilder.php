<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use PhpParser\BuilderFactory;
use PhpParser\Lexer;
use PhpParser\NodeTraverser;
use PhpParser\NodeTraverserInterface;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserAbstract;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Tebru\Dynamo\Cache\ClassModelCacher;
use Tebru\Dynamo\DataProvider\Factory\AnnotationDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\InterfaceDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\ParameterDataProviderFactory;
use Tebru\Dynamo\Model\Factory\ClassModelFactory;
use Tebru\Dynamo\Model\Factory\MethodModelFactory;
use Tebru\Dynamo\Model\Factory\ParameterModelFactory;
use Tebru\Dynamo\Model\Transformer\ClassModelTransformer;

/**
 * Class GeneratorBuilder
 *
 * @author Nate Brunette <n@tebru.net>
 */
class GeneratorBuilder
{
    /**
     * Prepended to generated class namespace
     *
     * @var string
     */
    private $namespacePrefix;

    /**
     * Creates parameter data providers
     *
     * @var ParameterDataProviderFactory
     */
    private $parameterDataProviderFactory;

    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Creates annotation data providers
     *
     * @var AnnotationDataProviderFactory
     */
    private $annotationDataProviderFactory;

    /**
     * Creates method data providers
     *
     * @var MethodDataProviderFactory
     */
    private $methodDataProviderFactory;

    /**
     * Creates interface data providers
     *
     * @var InterfaceDataProviderFactory
     */
    private $interfaceDataProviderFactory;

    /**
     * Creates parameter models
     *
     * @var ParameterModelFactory
     */
    private $parameterModelFactory;

    /**
     * Creates method models
     *
     * @var MethodModelFactory
     */
    private $methodModelFactory;

    /**
     * Symfony event dispatcher
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Creates class models
     *
     * @var ClassModelFactory
     */
    private $classModelFactory;

    /**
     * Directory to store cached files
     *
     * @var string
     */
    private $cacheDir;

    /**
     * Symfony filesystem
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * PHP parser builder factory for code generation
     *
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * PHP parser lexer
     *
     * @var Lexer
     */
    private $lexer;

    /**
     * PHP parser
     *
     * @var ParserAbstract
     */
    private $parser;

    /**
     * PHP parser node traverser
     *
     * @var NodeTraverserInterface
     */
    private $traverser;

    /**
     * Creates PHP parser objects from Dynamo class model
     *
     * @var ClassModelTransformer
     */
    private $classModelTransformer;

    /**
     * Pretty printer
     *
     * @var PrettyPrinterAbstract
     */
    private $printer;

    /**
     * Writes class model to disk
     *
     * @var ClassModelCacher
     */
    private $classModelCacher;

    /**
     * @param string $namespacePrefix
     * @return $this
     */
    public function setNamespacePrefix($namespacePrefix)
    {
        $this->namespacePrefix = $namespacePrefix;

        return $this;
    }

    /**
     * @param ParameterDataProviderFactory $parameterDataProviderFactory
     * @return $this
     */
    public function setParameterDataProviderFactory(ParameterDataProviderFactory $parameterDataProviderFactory)
    {
        $this->parameterDataProviderFactory = $parameterDataProviderFactory;

        return $this;
    }

    /**
     * @param Reader $reader
     * @return $this
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @param AnnotationDataProviderFactory $annotationDataProviderFactory
     * @return $this
     */
    public function setAnnotationDataProviderFactory(AnnotationDataProviderFactory $annotationDataProviderFactory)
    {
        $this->annotationDataProviderFactory = $annotationDataProviderFactory;

        return $this;
    }

    /**
     * @param MethodDataProviderFactory $methodDataProviderFactory
     * @return $this
     */
    public function setMethodDataProviderFactory(MethodDataProviderFactory $methodDataProviderFactory)
    {
        $this->methodDataProviderFactory = $methodDataProviderFactory;

        return $this;
    }

    /**
     * @param InterfaceDataProviderFactory $interfaceDataProviderFactory
     * @return $this
     */
    public function setInterfaceDataProviderFactory(InterfaceDataProviderFactory $interfaceDataProviderFactory)
    {
        $this->interfaceDataProviderFactory = $interfaceDataProviderFactory;

        return $this;
    }

    /**
     * @param ParameterModelFactory $parameterModelFactory
     * @return $this
     */
    public function setParameterModelFactory(ParameterModelFactory $parameterModelFactory)
    {
        $this->parameterModelFactory = $parameterModelFactory;

        return $this;
    }

    /**
     * @param MethodModelFactory $methodModelFactory
     * @return $this
     */
    public function setMethodModelFactory(MethodModelFactory $methodModelFactory)
    {
        $this->methodModelFactory = $methodModelFactory;

        return $this;
    }

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @return $this
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @param ClassModelFactory $classModelFactory
     * @return $this
     */
    public function setClassModelFactory(ClassModelFactory $classModelFactory)
    {
        $this->classModelFactory = $classModelFactory;

        return $this;
    }

    /**
     * @param string $cacheDir
     * @return $this
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }

    /**
     * @param Filesystem $filesystem
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * @param BuilderFactory $builderFactory
     * @return $this
     */
    public function setBuilderFactory(BuilderFactory $builderFactory)
    {
        $this->builderFactory = $builderFactory;

        return $this;
    }

    /**
     * @param Lexer $lexer
     * @return $this
     */
    public function setLexer(Lexer $lexer)
    {
        $this->lexer = $lexer;

        return $this;
    }

    /**
     * @param ParserAbstract $parser
     * @return $this
     */
    public function setParser(ParserAbstract $parser)
    {
        $this->parser = $parser;

        return $this;
    }

    /**
     * @param NodeTraverserInterface $traverser
     * @return $this
     */
    public function setTraverser(NodeTraverserInterface $traverser)
    {
        $this->traverser = $traverser;

        return $this;
    }

    /**
     * @param ClassModelTransformer $classModelTransformer
     * @return $this
     */
    public function setClassModelTransformer(ClassModelTransformer $classModelTransformer)
    {
        $this->classModelTransformer = $classModelTransformer;

        return $this;
    }

    /**
     * @param PrettyPrinterAbstract $printer
     * @return $this
     */
    public function setPrinter(PrettyPrinterAbstract $printer)
    {
        $this->printer = $printer;

        return $this;
    }

    /**
     * @param ClassModelCacher $classModelCacher
     * @return $this
     */
    public function setClassModelCacher(ClassModelCacher $classModelCacher)
    {
        $this->classModelCacher = $classModelCacher;

        return $this;
    }

    /**
     * Create a generator using sensible defaults when possible
     *
     * @return Generator
     */
    public function build()
    {
        if (null === $this->namespacePrefix) {
            $this->namespacePrefix = 'Dynamo';
        }

        if (null === $this->parameterDataProviderFactory) {
            $this->parameterDataProviderFactory = new ParameterDataProviderFactory();
        }

        if (null === $this->reader) {
            $this->reader = new AnnotationReader();
        }

        if (null === $this->annotationDataProviderFactory) {
            $this->annotationDataProviderFactory = new AnnotationDataProviderFactory($this->reader);
        }

        if (null === $this->methodDataProviderFactory) {
            $this->methodDataProviderFactory = new MethodDataProviderFactory($this->parameterDataProviderFactory, $this->annotationDataProviderFactory);
        }

        if (null === $this->interfaceDataProviderFactory) {
            $this->interfaceDataProviderFactory = new InterfaceDataProviderFactory($this->methodDataProviderFactory, $this->reader);
        }

        if (null === $this->parameterModelFactory) {
            $this->parameterModelFactory = new ParameterModelFactory();
        }

        if (null === $this->methodModelFactory) {
            $this->methodModelFactory = new MethodModelFactory($this->parameterModelFactory);
        }

        if (null === $this->eventDispatcher) {
            $this->eventDispatcher = new EventDispatcher();
        }

        if (null === $this->classModelFactory) {
            $this->classModelFactory = new ClassModelFactory($this->namespacePrefix, $this->interfaceDataProviderFactory, $this->methodModelFactory, $this->eventDispatcher);
        }

        if (null === $this->cacheDir) {
            $this->cacheDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'dynamo';
        }

        if (null === $this->filesystem) {
            $this->filesystem = new Filesystem();
        }

        if (null === $this->builderFactory) {
            $this->builderFactory = new BuilderFactory();
        }

        if (null === $this->lexer) {
            $this->lexer = new Lexer();
        }

        if (null === $this->parser) {
            $this->parser = new Parser($this->lexer);
        }

        if (null === $this->traverser) {
            $this->traverser = new NodeTraverser();
        }

        $this->traverser->addVisitor(new NameResolver());

        if (null === $this->classModelTransformer) {
            $this->classModelTransformer = new ClassModelTransformer($this->builderFactory, $this->parser, $this->traverser);
        }

        if (null === $this->printer) {
            $this->printer = new Standard();
        }

        if (null === $this->classModelCacher) {
            $this->classModelCacher = new ClassModelCacher($this->cacheDir, $this->filesystem, $this->classModelTransformer, $this->printer);
        }

        $generator = new Generator($this->classModelFactory, $this->classModelCacher);

        return $generator;
    }
}
