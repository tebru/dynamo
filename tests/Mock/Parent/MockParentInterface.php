<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock\Parent;

use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\Parent\Parent\MockParentParentInterface;

/**
 * Interface MockParentInterface
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @MockAnnotation()
 */
interface MockParentInterface extends MockParentParentInterface
{
    const CONST2 = 'const2';

    public function method2(callable $arg1, $arg2 = self::CONST2);
}
