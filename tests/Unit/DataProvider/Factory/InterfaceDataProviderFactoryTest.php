<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Test\Unit\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
use Mockery;
use Tebru\Dynamo\DataProvider\Factory\InterfaceDataProviderFactory;
use Tebru\Dynamo\DataProvider\Factory\MethodDataProviderFactory;
use Tebru\Dynamo\DataProvider\InterfaceDataProvider;
use Tebru\Dynamo\Test\Mock\MockInterface;
use Tebru\Dynamo\Test\Unit\MockeryTestCase;

/**
 * Class InterfaceDataProviderFactoryTest
 *
 * @author Nate Brunette <n@tebru.net>
 */
class InterfaceDataProviderFactoryTest extends MockeryTestCase
{
    public function testCanCreateInterfaceDataProvider()
    {
        $factory = new InterfaceDataProviderFactory(Mockery::mock(MethodDataProviderFactory::class), Mockery::mock(Reader::class));
        $provider = $factory->make(MockInterface::class);

        $this->assertInstanceOf(InterfaceDataProvider::class, $provider);
    }
}
