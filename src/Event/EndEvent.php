<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Event;

use Symfony\Component\EventDispatcher\Event;
use Tebru\Dynamo\Model\ClassModel;

/**
 * Class EndEvent
 *
 * @author Nate Brunette <n@tebru.net>
 */
class EndEvent extends Event
{
    const NAME = 'dynamo.after';

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
