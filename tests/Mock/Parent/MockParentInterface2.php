<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock\Parent;

use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockClass;

/**
 * Interface MockParentInterface2
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface MockParentInterface2
{
    /**
     * @MockAnnotation()
     */
    public function method1(MockClass $arg1, array $arg2);
    public function method3($arg1 = 1, $arg2 = 'test', $arg3 = false, $arg4 = []);
}
