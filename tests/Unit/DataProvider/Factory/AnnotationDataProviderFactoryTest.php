<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
use Mockery;
use ReflectionMethod;
use Tebru\Dynamo\DataProvider\AnnotationDataProvider;
use Tebru\Dynamo\DataProvider\Factory\AnnotationDataProviderFactory;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class AnnotationDataProviderFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class AnnotationDataProviderFactoryTest extends MockeryTestCase
{
    public function testCanCreateFactory()
    {
        $factory = new AnnotationDataProviderFactory(Mockery::mock(Reader::class));

        $this->assertInstanceOf(AnnotationDataProviderFactory::class, $factory);
    }

    public function testCanMAkeAnnotationDataProvider()
    {
        $factory = new AnnotationDataProviderFactory(Mockery::mock(Reader::class));
        $provider =  $factory->make(Mockery::mock(ReflectionMethod::class));

        $this->assertInstanceOf(AnnotationDataProvider::class, $provider);
    }
}
