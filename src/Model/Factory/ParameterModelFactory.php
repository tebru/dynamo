<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model\Factory;

use Tebru\Dynamo\DataProvider\ParameterDataProvider;
use Tebru\Dynamo\Model\MethodModel;
use Tebru\Dynamo\Model\ParameterModel;

/**
 * Class ParameterModelFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ParameterModelFactory
{
    public function make(MethodModel $methodModel, ParameterDataProvider $parameterDataProvider)
    {
        $optional = $parameterDataProvider->hasDefaultValue();
        $parameter = new ParameterModel($methodModel, $parameterDataProvider->getName(), $optional);
        $parameter->setTypeHint($parameterDataProvider->getTypeHint());

        if ($optional) {
            $parameter->setDefaultValue($parameterDataProvider->getDefaultValue());
        }

        return $parameter;
    }
}
