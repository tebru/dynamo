<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Collection;

use InvalidArgumentException;

/**
 * Class AnnotationCollection
 *
 * A collection of both class and method level annotations
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationCollection
{
    /**
     * A list of class level annotations
     *
     * @var array
     */
    private $classAnnotations = [];

    /**
     * A list of method level annotations
     *
     * @var array
     */
    private $methodAnnotations = [];

    /**
     * Get class and method annotations together
     *
     * @return array
     */
    public function getAnnotations()
    {
        $returnAnnotations = [];

        foreach ($this->classAnnotations as $key => $classAnnotation) {
            foreach ($classAnnotation as $annotation) {
                $returnAnnotations[$key][] = $annotation;
            }
        }

        foreach ($this->methodAnnotations as $key => $methodAnnotation) {
            foreach ($methodAnnotation as $annotation) {
                $returnAnnotations[$key][] = $annotation;
            }
        }

        return $returnAnnotations;
    }

    /**
     * Get only the method annotations
     *
     * @return array
     */
    public function getMethodAnnotations()
    {
        return $this->methodAnnotations;
    }

    /**
     * Get only the class annotations
     *
     * @return array
     */
    public function getClassAnnotations()
    {
        return $this->classAnnotations;
    }

    /**
     * Set all of the method annotations
     *
     * @param array $methodAnnotations
     * @return $this
     */
    public function setMethodAnnotations(array $methodAnnotations)
    {
        $this->methodAnnotations = [];
        foreach ($methodAnnotations as $methodAnnotation) {
            $this->addMethodAnnotation($methodAnnotation);
        }

        return $this;
    }

    /**
     * Set all of the class annotations
     *
     * @param array $classAnnotations
     * @return $this
     */
    public function setClassAnnotations(array $classAnnotations)
    {
        $this->classAnnotations = [];
        foreach ($classAnnotations as $classAnnotation) {
            $this->addClassAnnotation($classAnnotation);
        }

        return $this;
    }

    /**
     * Add a method annotation to the list
     *
     * @param $annotation
     * @return $this
     */
    public function addMethodAnnotation($annotation)
    {
        if (!is_object($annotation)) {
            throw new InvalidArgumentException('Annotation must be an object');
        }

        $this->methodAnnotations[get_class($annotation)][] = $annotation;

        return $this;
    }

    /**
     * Add a class annotation to the list
     *
     * @param $annotation
     * @return $this
     */
    public function addClassAnnotation($annotation)
    {
        if (!is_object($annotation)) {
            throw new InvalidArgumentException('Annotation must be an object');
        }

        $this->classAnnotations[get_class($annotation)][] = $annotation;

        return $this;
    }

    /**
     * See if class or method annotation exists
     *
     * @param string $name
     * @return bool
     */
    public function annotationExists($name)
    {
        if ($this->methodAnnotationExists($name) || $this->classAnnotationExists($name)) {
            return true;
        }

        return false;
    }

    /**
     * See if method annotation exists
     *
     * @param string $name
     * @return bool
     */
    public function methodAnnotationExists($name)
    {
        return array_key_exists($name, $this->methodAnnotations);
    }

    /**
     * See if class annotation exists
     *
     * @param string $name
     * @return bool
     */
    public function classAnnotationExists($name)
    {
        return array_key_exists($name, $this->classAnnotations);
    }
}
