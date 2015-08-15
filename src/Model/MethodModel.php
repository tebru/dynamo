<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model;

use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;

/**
 * Class MethodModel
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MethodModel
{
    /**
     * Reference to the class model
     *
     * @var ClassModel
     */
    private $classModel;

    /**
     * Method name
     *
     * @var string
     */
    private $name;

    /**
     * Method parameters
     *
     * @var ParameterModel[]|ArrayCollection
     */
    private $parameters;

    /**
     * The method body as a string
     *
     * @var string
     */
    private $body;

    /**
     * Constructor
     *
     * @param ClassModel $classModel
     * @param $name
     */
    public function __construct(ClassModel $classModel, $name)
    {
        $this->classModel = $classModel;
        $this->name = $name;
        $this->parameters = new ArrayCollection();
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
     * Get the method name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the method name
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
     * Add a parameter to the class
     *
     * @param ParameterModel $parameterModel
     * @return $this
     */
    public function addParameter(ParameterModel $parameterModel)
    {
        if ($this->parameters->containsKey($parameterModel->getName())) {
            throw new InvalidArgumentException(sprintf('Parameter "%s" already exists in method', $parameterModel->getName()));
        }

        $this->parameters->set($parameterModel->getName(), $parameterModel);

        return $this;
    }

    /**
     * Remove a parameter from class
     *
     * @param ParameterModel $parameterModel
     * @return $this
     */
    public function removeParameter(ParameterModel $parameterModel)
    {
        $this->parameters->remove($parameterModel->getName());

        return $this;
    }

    /**
     * Get a parameter by name
     *
     * @param $parameterName
     * @return ParameterModel
     */
    public function getParameter($parameterName)
    {
        if (!$this->parameters->containsKey($parameterName)) {
            throw new InvalidArgumentException(sprintf('Parameter "%s" does not exist in method', $parameterName));
        }

        return $this->parameters->get($parameterName);
    }

    /**
     * Return all method parameters
     *
     * @return ParameterModel[]
     */
    public function getParameters()
    {
        return $this->parameters->toArray();
    }

    /**
     * Set the method body
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the method body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
