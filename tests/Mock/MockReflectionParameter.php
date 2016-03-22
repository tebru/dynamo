<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock;

use ReflectionParameter;

/**
 * Interface MockReflectionParameter
 *
 * Adds methods added in php >= 5.4
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MockReflectionParameter extends ReflectionParameter
{
    public function getType() {}
    public function hasType () {}
    public function isVariadic() {}
}
