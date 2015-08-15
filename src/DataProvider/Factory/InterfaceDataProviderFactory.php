<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider\Factory;

use Doctrine\Common\Annotations\Reader;
use Tebru\Dynamo\DataProvider\InterfaceDataProvider;

/**
 * Class InterfaceDataProviderFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class InterfaceDataProviderFactory
{
    /**
     * Creates method data providers
     *
     * @var MethodDataProviderFactory
     */
    private $methodDataProviderFactory;

    /**
     * Doctrine annotation reader
     *
     * @var Reader
     */
    private $reader;

    /**
     * Constructor
     *
     * @param MethodDataProviderFactory $methodDataProviderFactory
     * @param Reader $reader
     */
    public function __construct(MethodDataProviderFactory $methodDataProviderFactory, Reader $reader)
    {
        $this->methodDataProviderFactory = $methodDataProviderFactory;
        $this->reader = $reader;
    }

    /**
     * Create a new method data provider
     *
     * @param string $interfaceName
     * @return InterfaceDataProvider
     */
    public function make($interfaceName)
    {
        return new InterfaceDataProvider($interfaceName, $this->methodDataProviderFactory, $this->reader);
    }
}
