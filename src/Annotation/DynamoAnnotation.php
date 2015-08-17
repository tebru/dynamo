<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Annotation;

/**
 * Interface DynamoAnnotation
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface DynamoAnnotation
{
    /**
     * The name of the annotation or class of annotations
     *
     * @return string
     */
    public function getName();

    /**
     * Whether or not multiple annotations of this type can
     * be added to a method
     *
     * @return bool
     */
    public function allowMultiple();
}
