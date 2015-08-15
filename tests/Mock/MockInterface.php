<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock;

use Tebru\Dynamo\Test\Mock\Parent\MockParentInterface;
use Tebru\Dynamo\Test\Mock\Parent\MockParentInterface2;

/**
 * Interface MockInterface
 *
 * @author Nate Brunette <n@tebru.net>
 */
interface MockInterface extends MockParentInterface, MockParentInterface2
{
    const CONST1 = 'const1';

    public function method1(MockClass $arg1, array $arg2 = null);
}
