<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\Collection;

use PHPUnit_Framework_TestCase;
use Tebru\Dynamo\Collection\AnnotationCollection;
use Tebru\Dynamo\Test\Mock\MockAnnotation;

/**
 * Class AnnotationCollectionTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testCanAddClassAnnotation()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($annotation);

        $annotations = $collection->getClassAnnotations();
        $this->assertSame($annotation, $annotations[MockAnnotation::class][0]);
    }

    public function testCanAddMultipleClassAnnotations()
    {
        $annotation1 = new MockAnnotation();
        $annotation2 = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->setClassAnnotations([$annotation1, $annotation2]);

        $annotations = $collection->getClassAnnotations();
        $this->assertSame($annotation1, $annotations[MockAnnotation::class][0]);
        $this->assertSame($annotation2, $annotations[MockAnnotation::class][1]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddClassAnnotationThrowsException()
    {
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation('test');
    }

    public function testCanAddMethodAnnotation()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation($annotation);

        $annotations = $collection->getMethodAnnotations();
        $this->assertSame($annotation, $annotations[MockAnnotation::class][0]);
    }

    public function testCanAddMultipleMethodAnnotations()
    {
        $annotation1 = new MockAnnotation();
        $annotation2 = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->setMethodAnnotations([$annotation1, $annotation2]);

        $annotations = $collection->getMethodAnnotations();
        $this->assertSame($annotation1, $annotations[MockAnnotation::class][0]);
        $this->assertSame($annotation2, $annotations[MockAnnotation::class][1]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddMethodAnnotationThrowsException()
    {
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation('test');
    }

    public function testCanGetClassAnnotations()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($annotation);

        $this->assertEquals([MockAnnotation::class => [$annotation]], $collection->getClassAnnotations());
    }

    public function testCanGetMethodAnnotations()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation($annotation);

        $this->assertEquals([MockAnnotation::class => [$annotation]], $collection->getMethodAnnotations());
    }

    public function testCanAddBothClassAndMethodAnnotations()
    {
        $classAnnotation1 = new MockAnnotation();
        $classAnnotation2 = new MockAnnotation();
        $methodAnnotation1 = new MockAnnotation();
        $methodAnnotation2 = new MockAnnotation();

        $collection = new AnnotationCollection();
        $collection->setMethodAnnotations([$methodAnnotation1, $methodAnnotation2]);
        $collection->setClassAnnotations([$classAnnotation1, $classAnnotation2]);

        $annotations = $collection->getAnnotations();
        $this->assertSame($classAnnotation1, $annotations[MockAnnotation::class][0]);
        $this->assertSame($classAnnotation2, $annotations[MockAnnotation::class][1]);
        $this->assertSame($methodAnnotation1, $annotations[MockAnnotation::class][2]);
        $this->assertSame($methodAnnotation2, $annotations[MockAnnotation::class][3]);
    }

    public function testCanGetBothClassAndMethodAnnotations()
    {
        $classAnnotation1 = new MockAnnotation();
        $classAnnotation2 = new MockAnnotation();
        $methodAnnotation1 = new MockAnnotation();
        $methodAnnotation2 = new MockAnnotation();

        $collection = new AnnotationCollection();
        $collection->setMethodAnnotations([$methodAnnotation1, $methodAnnotation2]);
        $collection->setClassAnnotations([$classAnnotation1, $classAnnotation2]);

        $expected = [MockAnnotation::class => [$classAnnotation1, $classAnnotation2, $methodAnnotation1, $methodAnnotation2]];
        $this->assertEquals($expected, $collection->getAnnotations());
    }

    public function testClassAnnotationExists()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($annotation);

        $this->assertTrue($collection->classAnnotationExists(MockAnnotation::class));
    }

    public function testClassAnnotationDoesNotExist()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation($annotation);

        $this->assertFalse($collection->classAnnotationExists(MockAnnotation::class));
    }

    public function testMethodAnnotationExists()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation($annotation);

        $this->assertTrue($collection->methodAnnotationExists(MockAnnotation::class));
    }

    public function testMethodAnnotationDoesNotExist()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($annotation);

        $this->assertFalse($collection->methodAnnotationExists(MockAnnotation::class));
    }

    public function testAnnotationExistsClassOnly()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($annotation);

        $this->assertTrue($collection->annotationExists(MockAnnotation::class));
    }

    public function testAnnotationExistsMethodOnly()
    {
        $annotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addMethodAnnotation($annotation);

        $this->assertTrue($collection->annotationExists(MockAnnotation::class));
    }

    public function testAnnotationExistsBothClassAndMethod()
    {
        $classAnnotation = new MockAnnotation();
        $methodAnnotation = new MockAnnotation();
        $collection = new AnnotationCollection();
        $collection->addClassAnnotation($classAnnotation);
        $collection->addMethodAnnotation($methodAnnotation);

        $this->assertTrue($collection->annotationExists(MockAnnotation::class));
    }

    public function testAnnotationDoesNotExistBothClassAndMethod()
    {
        $collection = new AnnotationCollection();

        $this->assertFalse($collection->annotationExists(MockAnnotation::class));
    }
}
