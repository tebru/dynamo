<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock\Annotation;

use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockAnnotation2;

/**
 * Interface MockAnnotationParentInterface
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @MockAnnotation()
 */
interface MockAnnotationParentInterface
{
    /**
     * @MockAnnotation()
     * @MockAnnotation2()
     */
    public function method();
}
