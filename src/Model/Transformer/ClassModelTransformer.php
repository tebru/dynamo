<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Model\Transformer;

use PhpParser\BuilderFactory;
use PhpParser\NodeTraverserInterface;
use PhpParser\ParserAbstract;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\PropertyModel;
use UnexpectedValueException;

/**
 * Class ClassModelTransformer
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelTransformer
{
    /**
     * PHP Parser factory to create nodes
     *
     * @var BuilderFactory
     */
    private $factory;

    /**
     * PHP Parser parser used to create method body
     *
     * @var ParserAbstract
     */
    private $parser;

    /**
     * Traverse parsed statements
     *
     * @var NodeTraverserInterface
     */
    private $nodeTraverser;

    /**
     * Constructor
     *
     * @param BuilderFactory $factory
     * @param ParserAbstract $parser
     * @param NodeTraverserInterface $nodeTraverser
     */
    public function __construct(BuilderFactory $factory, ParserAbstract $parser, NodeTraverserInterface $nodeTraverser)
    {
        $this->factory = $factory;
        $this->parser = $parser;
        $this->nodeTraverser = $nodeTraverser;
    }

    /**
     * Convert a ClassModel into an array of statements for the php parser
     *
     * @param ClassModel $classModel
     * @return array
     */
    public function transform(ClassModel $classModel)
    {
        // create namespace
        $namespace = $this->factory->namespace($classModel->getNamespace());

        // create class
        $class = $this->factory->class($classModel->getName());
        $class->implement($classModel->getInterface());

        // add class properties
        foreach ($classModel->getProperties() as $propertyModel) {
            $property = $this->factory->property($propertyModel->getName());
            $property->setDefault($propertyModel->getDefaultValue());

            switch ($propertyModel->getVisibility()) {
                case PropertyModel::VISIBILITY_PUBLIC:
                    $property->makePublic();
                    break;
                case PropertyModel::VISIBILITY_PROTECTED:
                    $property->makeProtected();
                    break;
                case PropertyModel::VISIBILITY_PRIVATE:
                    $property->makePrivate();
                    break;
                default:
                    throw new UnexpectedValueException('Property visibility must be public, protected, private');
            }
        }

        // add class methods
        foreach ($classModel->getMethods() as $methodModel) {
            $method = $this->factory->method($methodModel->getName());
            $method->makePublic();

            // add method body
            $methodStatements = $this->parser->parse($methodModel->getBody());

            if (null !== $methodStatements) {
                $methodStatements = $this->nodeTraverser->traverse($methodStatements);
                $method->addStmts($methodStatements);
            }

            // add method parameters
            foreach ($methodModel->getParameters() as $parameterModel) {
                $parameter = $this->factory->param($parameterModel->getName());

                if ($parameterModel->hasTypeHint()) {
                    $parameter->setTypeHint($parameterModel->getTypeHint());
                }

                if ($parameterModel->isOptional()) {
                    $parameter->setDefault($parameterModel->getDefaultValue());
                }

                $method->addParam($parameter);
            }

            // add method to class
            $class->addStmt($method);
        }

        // add class to namespace
        $namespace->addStmt($class);

        // return an array of statements
        return [$namespace->getNode()];
    }
}
