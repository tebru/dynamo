<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
use ReflectionMethod;
use Tebru\Dynamo\DataProvider\AnnotationDataProvider;

/**
 * Class AnnotationDataProviderFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationDataProviderFactory
{
    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Create a new annotation data provider
     *
     * @param ReflectionMethod $reflectionMethod
     * @return AnnotationDataProvider
     */
    public function make(ReflectionMethod $reflectionMethod)
    {
        return new AnnotationDataProvider($this->reader, $reflectionMethod);
    }
}
