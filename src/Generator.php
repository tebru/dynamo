<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo;

use Tebru\Dynamo\Cache\ClassModelCacher;
use Tebru\Dynamo\Model\Factory\ClassModelFactory;

/**
 * Class Generator
 *
 * @author Nate Brunette <n@tebru.net>
 */
class Generator
{
    /**
     * Creates class models
     *
     * @var ClassModelFactory
     */
    private $classModelFactory;

    /**
     * Writes class models to disk
     *
     * @var ClassModelCacher
     */
    private $cacher;

    /**
     * Constructor
     *
     * @param ClassModelFactory $classModelFactory
     * @param ClassModelCacher $cacher
     */
    public function __construct(ClassModelFactory $classModelFactory, ClassModelCacher $cacher)
    {
        $this->classModelFactory = $classModelFactory;
        $this->cacher = $cacher;
    }

    /**
     * Create a new generator builder
     *
     * @return GeneratorBuilder
     */
    public static function builder()
    {
        return new GeneratorBuilder();
    }

    /**
     * Given an interface name, create a class and write it to disk
     *
     * This method will dispatch events that can be used to set method bodies or modify the class
     *
     * @param string $interfaceName
     * @return $this;
     */
    public function createAndWrite($interfaceName)
    {
        $classModel = $this->classModelFactory->make($interfaceName);
        $this->cacher->write($classModel);

        return $this;
    }

}
