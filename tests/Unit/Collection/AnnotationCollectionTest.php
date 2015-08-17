<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Collection;

use PHPUnit_Framework_TestCase;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\Test\Mock\MockAnnotation;
use Tebru\Dynamo\Test\Mock\MockAnnotation2;

/**
 * Class AnnotationCollectionTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testCanAddAnnotation()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation);

        $this->assertAttributeSame(['mock' => [$annotation]], 'annotations', $collection);
    }

    public function testCanAddMultipleAnnotations()
    {
        $annotation1 = new MockAnnotation();
        $annotation2 = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotations([$annotation1, $annotation2]);

        $this->assertAttributeSame(['mock' => [$annotation1, $annotation2]], 'annotations', $collection);
    }

    /**
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage May not use multiple instances of annotation
     */
    public function testAddAnnotationThrowsException()
    {
        $collection = new AnnotationCollection();
        $collection->addAnnotation(new MockAnnotation2());
        $collection->addAnnotation(new MockAnnotation2());
    }

    public function testCanGetAllAnnotations()
    {
        $annotation1 = new MockAnnotation();
        $annotation2 = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation1);
        $collection->addAnnotation($annotation2);

        $this->assertSame(['mock' => [$annotation1, $annotation2]], $collection->getAnnotations());
    }

    public function testCanGetSingleAnnotation()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation);

        $this->assertSame([$annotation], $collection->get(MockAnnotation::NAME));
    }


    public function testAnnotationExists()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation);

        $this->assertTrue($collection->exists(MockAnnotation::NAME));
    }

    public function testAnnotationDoesNotExist()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation);

        $this->assertFalse($collection->exists(MockAnnotation2::class));
    }

    public function testCanIterate()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addAnnotation($annotation);

        foreach ($collection as $key => $a) {
            $this->assertSame('mock', $key);
            $this->assertSame([$annotation], $a);
        }
    }
}
