<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Event;

use Mockery;
use Tebru\Dynamo\Event\EndEvent;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class EndEventTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class EndEventTest extends MockeryTestCase
{
    public function testCreateEvent()
    {
        $classModel = Mockery::mock(ClassModel::class);
        $event = new EndEvent($classModel);

        $this->assertInstanceOf(EndEvent::class, $event);
    }

    public function testGetClassModel()
    {
        $classModel = Mockery::mock(ClassModel::class);
        $event = new EndEvent($classModel);

        $this->assertInstanceOf(ClassModel::class, $event->getClassModel());
    }
}
