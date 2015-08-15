<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Event;

use Symfony\Component\EventDispatcher\Event;
use Tebru\Dynamo\Model\ClassModel;

/**
 * Class StartEvent
 *
 * @author Nate Brunette <n@tebru.net>
 */
class StartEvent extends Event
{
    const NAME = 'dynamo.before';

    /**
     * Class model
     *
     * @var ClassModel
     */
    private $classModel;

    /**
     * Constructor
     *
     * @param ClassModel $classModel
     */
    public function __construct(ClassModel $classModel)
    {
        $this->classModel = $classModel;
    }

    /**
     * Get the class model
     *
     * @return ClassModel
     */
    public function getClassModel()
    {
        return $this->classModel;
    }
}
