<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model\Factory;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\DataProvider\Factory\InterfaceDataProviderFactory;
use Tebru\Dynamo\Event\EndEvent;
use Tebru\Dynamo\Event\StartEvent;
use Tebru\Dynamo\Event\MethodEvent;
use Tebru\Dynamo\Model\ClassModel;

/**
 * Class ClassModelFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelFactory
{
    private $namespacePrefix;
    /**
     * @var InterfaceDataProviderFactory
     */
    private $interfaceDataProviderFactory;
    /**
     * @var MethodModelFactory
     */
    private $methodModelFactory;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * Constructor
     *
     * @param string $namespacePrefix
     * @param InterfaceDataProviderFactory $interfaceDataProviderFactory
     * @param MethodModelFactory $methodModelFactory
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        $namespacePrefix,
        InterfaceDataProviderFactory $interfaceDataProviderFactory,
        MethodModelFactory $methodModelFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->namespacePrefix = $namespacePrefix;
        $this->interfaceDataProviderFactory = $interfaceDataProviderFactory;
        $this->methodModelFactory = $methodModelFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Create a new class model from an interface
     *
     * @param string $interfaceName
     * @return ClassModel
     */
    public function make($interfaceName)
    {
        $interfaceDataProvider = $this->interfaceDataProviderFactory->make($interfaceName);
        $classAnnotations = $interfaceDataProvider->getAnnotations();

        $namespace = $this->namespacePrefix . '\\' . $interfaceDataProvider->getNamespace();
        $classModel = new ClassModel($namespace, $interfaceDataProvider->getName(), $interfaceDataProvider->getFullName());

        // dispatch the start event
        $this->eventDispatcher->dispatch(StartEvent::NAME, new StartEvent($classModel));

        $methods = $interfaceDataProvider->getMethods();
        foreach ($methods as $methodDataProvider) {
            $methodModel = $this->methodModelFactory->make($classModel, $methodDataProvider);

            $annotationCollection = new AnnotationCollection();
            $annotationCollection->setClassAnnotations($classAnnotations);
            $annotationCollection->setMethodAnnotations($methodDataProvider->getAnnotations());

            // dispatch the method event
            $this->eventDispatcher->dispatch(MethodEvent::NAME, new MethodEvent($methodModel, $annotationCollection));

            $classModel->addMethod($methodModel);
        }

        // dispatch the end event
        $this->eventDispatcher->dispatch(EndEvent::NAME, new EndEvent($classModel));

        return $classModel;
    }
}
