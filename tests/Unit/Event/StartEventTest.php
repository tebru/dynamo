<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Event;

use Mockery;
use Tebru\Dynamo\Event\StartEvent;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class StartEventTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class StartEventTest extends MockeryTestCase
{
    public function testCreateEvent()
    {
        $classModel = Mockery::mock(ClassModel::class);
        $event = new StartEvent($classModel);

        $this->assertInstanceOf(StartEvent::class, $event);
    }

    public function testGetClassModel()
    {
        $classModel = Mockery::mock(ClassModel::class);
        $event = new StartEvent($classModel);

        $this->assertInstanceOf(ClassModel::class, $event->getClassModel());
    }
}
