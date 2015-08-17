<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock\Annotation;

use Tebru\Dynamo\Test\Mock\MockAnnotation;

/**
 * Interface MockAnnotationInterface
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface MockAnnotationInterface extends MockAnnotationParentInterface, MockAnnotationParentParentInterface
{
    /**
     * @MockAnnotation()
     */
    public function method();
}
