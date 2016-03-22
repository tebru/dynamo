<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Annotation;

use Tebru\Dynamo\Annotation\Dynamo;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class DynamoTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class DynamoTest extends MockeryTestCase
{
    public function testGetName()
    {
        $dynamo = new Dynamo();

        $this->assertSame(Dynamo::NAME, $dynamo->getName());
    }

    public function testAllowMultiple()
    {
        $dynamo = new Dynamo();

        $this->assertFalse($dynamo->allowMultiple());
    }
}
