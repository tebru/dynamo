<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Tebru\Dynamo\Annotation\DynamoAnnotation;
use Tebru\Dynamo\Collection\AnnotationCollection;

/**
 * Class AnnotationDataProvider
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationDataProvider
{
    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * PHP reflection method
     *
     * @var ReflectionMethod
     */
    private $reflectionMethod;

    /**
     * Constructor
     *
     * @param Reader $reader
     * @param ReflectionMethod $reflectionMethod
     */
    public function __construct(Reader $reader, ReflectionMethod $reflectionMethod)
    {
        $this->reader = $reader;
        $this->reflectionMethod = $reflectionMethod;
    }

    /**
     * Get method annotations
     *
     * Also gets class annotations and parent method/class annotations
     *
     * @return AnnotationCollection
     */
    public function getAnnotations()
    {
        // start with all of the method annotations
        $annotationCollection = new AnnotationCollection();
        $annotations = $this->reader->getMethodAnnotations($this->reflectionMethod);
        $annotations = $this->getDynamoAnnotations($annotations);
        $annotationCollection->addAnnotations($annotations);

        // get method's class' annotations
        $reflectionClass = $this->reflectionMethod->getDeclaringClass();
        $this->getAdditionalClassAnnotations($reflectionClass, $annotationCollection);

        // parse parent interfaces too
        $parents = $reflectionClass->getInterfaceNames();
        foreach ($parents as $parent) {
            $parentReflectionClass = new ReflectionClass($parent);

            try {
                // check to see if there is a parent method
                $parentReflectionMethod = $parentReflectionClass->getMethod($this->reflectionMethod->getName());
            } catch (ReflectionException $exception) {
                // parent method does not exist, add parent class annotations
                $this->getAdditionalClassAnnotations($parentReflectionClass, $annotationCollection);

                continue;
            }

            // add parent method/class annotations
            $this->getAdditionalMethodAnnotations($parentReflectionMethod, $annotationCollection);
            $this->getAdditionalClassAnnotations($parentReflectionClass, $annotationCollection);
        }

        return $annotationCollection;
    }

    /**
     * Filter out non-dynamo annotations
     *
     * @param array $annotations
     * @return DynamoAnnotation[]
     */
    private function getDynamoAnnotations(array $annotations)
    {
        return array_filter($annotations, function ($annotation) {
            return $annotation instanceof DynamoAnnotation;
        });
    }

    /**
     * Add unique method annotations to collection
     *
     * @param ReflectionMethod $reflectionMethod
     * @param AnnotationCollection $annotationCollection
     */
    private function getAdditionalMethodAnnotations(ReflectionMethod $reflectionMethod, AnnotationCollection $annotationCollection)
    {
        $annotations = $this->reader->getMethodAnnotations($reflectionMethod);
        $annotations = $this->getDynamoAnnotations($annotations);

        foreach ($annotations as $annotation) {
            // skip annotations that already exist on method
            if ($annotationCollection->exists($annotation->getName())) {
                continue;
            }

            $annotationCollection->addAnnotation($annotation);
        }
    }

    /**
     * Add unique class annotations to collection
     *
     * @param ReflectionClass $reflectionClass
     * @param AnnotationCollection $annotationCollection
     */
    private function getAdditionalClassAnnotations(ReflectionClass $reflectionClass, AnnotationCollection $annotationCollection)
    {
        $annotations = $this->reader->getClassAnnotations($reflectionClass);
        $annotations = $this->getDynamoAnnotations($annotations);

        foreach ($annotations as $annotation) {
            // skip annotations that already exist on method
            if ($annotationCollection->exists($annotation->getName())) {
                continue;
            }

            $annotationCollection->addAnnotation($annotation);
        }
    }
}
