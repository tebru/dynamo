<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\DataProvider\Factory;

use ReflectionParameter;
use Tebru\Dynamo\DataProvider\ParameterDataProvider;

/**
 * Class ParameterDataProviderFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterDataProviderFactory
{
    /**
     * Creates a new parameter data provider
     *
     * @param ReflectionParameter $parameter
     * @return ParameterDataProvider
     */
    public function make(ReflectionParameter $parameter)
    {
        return new ParameterDataProvider($parameter);
    }
}
