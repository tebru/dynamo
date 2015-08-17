<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock;

use Tebru\Dynamo\Annotation\DynamoAnnotation;

/**
 * Class MockAnnotation2
 *
 * @author Nate Brunette <n@tebru.net>
 * @Annotation
 */
class MockAnnotation2 implements DynamoAnnotation
{
    const NAME = 'mock2';

    public function getName()
    {
        return self::NAME;
    }

    public function allowMultiple()
    {
        return false;
    }
}
