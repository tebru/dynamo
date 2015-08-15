<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Event;

use Mockery;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\Event\MethodEvent;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class MethodEventTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodEventTest extends MockeryTestCase
{
    public function testCreateEvent()
    {
        $methodModel = Mockery::mock(MethodModel::class);
        $annotationCollection = Mockery::mock(AnnotationCollection::class);
        $event = new MethodEvent($methodModel, $annotationCollection);

        $this->assertInstanceOf(MethodEvent::class, $event);
    }

    public function testGetClassModel()
    {
        $methodModel = Mockery::mock(MethodModel::class);
        $annotationCollection = Mockery::mock(AnnotationCollection::class);
        $event = new MethodEvent($methodModel, $annotationCollection);

        $this->assertInstanceOf(MethodModel::class, $event->getMethodModel());
    }

    public function testGetAnnotationCollection()
    {
        $methodModel = Mockery::mock(MethodModel::class);
        $annotationCollection = Mockery::mock(AnnotationCollection::class);
        $event = new MethodEvent($methodModel, $annotationCollection);

        $this->assertInstanceOf(AnnotationCollection::class, $event->getAnnotationCollection());
    }
}
