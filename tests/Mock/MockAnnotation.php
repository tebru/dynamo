<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Mock;

use Tebru\Dynamo\Annotation\DynamoAnnotation;

/**
 * Class MockAnnotation
 *
 * @author Nate Brunette <n@tebru.net>
 *
 * @Annotation
 */
class MockAnnotation implements DynamoAnnotation
{
    const NAME = 'mock';

    public function getName()
    {
        return self::NAME;
    }

    public function allowMultiple()
    {
        return true;
    }
}
