<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model;

/**
 * Class PropertyModel
 *
 * @author Nate Brunette <n@tebru.net>
 */
class PropertyModel
{
    /**#@+
     * Property visibility
     */
    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PROTECTED = 'protected';
    const VISIBILITY_PRIVATE = 'private';
    /**#@-*/

    /**
     * Reference to the class model
     *
     * @var ClassModel
     */
    private $classModel;

    /**
     * Property name
     *
     * @var string
     */
    private $name;

    /**
     * Property visibility
     *
     * @var string
     */
    private $visibility = self::VISIBILITY_PRIVATE;

    /**
     * Property default value
     *
     * @var mixed
     */
    private $defaultValue;

    /**
     * Constructor
     *
     * @param ClassModel $classModel
     * @param string $name
     */
    public function __construct(ClassModel $classModel, $name)
    {
        $this->classModel = $classModel;
        $this->name = $name;
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

    /**
     * Get the property name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the property name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the property visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set the property visibility
     *
     * @param string $visibility
     * @return $this
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get the property default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set the property default value
     *
     * @param mixed $defaultValue
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }
}
