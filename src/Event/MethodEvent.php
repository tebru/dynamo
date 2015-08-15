<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Event;

use Symfony\Component\EventDispatcher\Event;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\Model\MethodModel;

/**
 * Method MethodEvent
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodEvent extends Event
{
    const NAME = 'dynamo.method';

    /**
     * Method model
     *
     * @var MethodModel
     */
    private $methodModel;

    /**
     * Annotation collection
     *
     * @var AnnotationCollection
     */
    private $annotationCollection;

    /**
     * Constructor
     *
     * @param MethodModel $methodModel
     * @param AnnotationCollection $annotationCollection
     */
    public function __construct(MethodModel $methodModel, AnnotationCollection $annotationCollection)
    {
        $this->methodModel = $methodModel;
        $this->annotationCollection = $annotationCollection;
    }

    /**
     * Get the method model
     *
     * @return MethodModel
     */
    public function getMethodModel()
    {
        return $this->methodModel;
    }

    /**
     * Get the annotation collection
     *
     * @return AnnotationCollection
     */
    public function getAnnotationCollection()
    {
        return $this->annotationCollection;
    }
}
