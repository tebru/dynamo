<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Collection;

use ArrayIterator;
use Tebru;
use Tebru\Dynamo\Annotation\DynamoAnnotation;
use Traversable;
use UnexpectedValueException;

/**
 * Class AnnotationCollection
 *
 * A collection of both class and method level annotations
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationCollection implements \IteratorAggregate
{
    /**
     * A list of class level annotations
     *
     * @var DynamoAnnotation[]
     */
    private $annotations = [];

    /**
     * Get class and method annotations together
     *
     * @return DynamoAnnotation[]
     */
    public function getAnnotations()
    {
        return $this->annotations;
    }

    /**
     * See if class or method annotation exists
     *
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->annotations);
    }

    /**
     * Get an annotation by key
     *
     * @param string $name
     * @return object|array
     */
    public function get($name)
    {
        Tebru\assertArrayKeyExists($name, $this->annotations);

        return $this->annotations[$name];
    }

    /**
     * Set all of the method annotations
     *
     * @param DynamoAnnotation[] $annotations
     * @return $this
     */
    public function addAnnotations(array $annotations)
    {
        foreach ($annotations as $annotation) {
            $this->addAnnotation($annotation);
        }

        return $this;
    }

    /**
     * Add a method annotation to the list
     *
     * @param DynamoAnnotation $annotation
     * @return $this
     */
    public function addAnnotation(DynamoAnnotation $annotation)
    {
        if (!$annotation->allowMultiple() && $this->exists($annotation->getName())) {
            throw new UnexpectedValueException('May not use multiple instances of annotation');
        }

        if ($annotation->allowMultiple()) {
            $this->annotations[$annotation->getName()][] = $annotation;
        } else {
            $this->annotations[$annotation->getName()] = $annotation;
        }

        return $this;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new ArrayIterator($this->annotations);
    }
}
