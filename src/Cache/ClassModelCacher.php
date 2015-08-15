<?php
/*
 * Copyright (c) 2015 Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Dynamo\Cache;

use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\Filesystem\Filesystem;
use Tebru\Dynamo\Model\ClassModel;
use Tebru\Dynamo\Model\Transformer\ClassModelTransformer;

/**
 * Class ClassModelCacher
 *
 * Writes a ClassModel object to a file.  Takes a root cache directory and adds
 * the class' namespaced path.
 *
 * @author Nate Brunette <n@tebru.net>
 */
class ClassModelCacher
{
    /**
     * The root cache directory
     *
     * @var string
     */
    private $cacheDir;

    /**
     * Symfony filesystem
     *
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Transforms a class model to a php parser class
     *
     * @var ClassModelTransformer
     */
    private $classModelTransformer;

    /**
     * Pretty printer
     *
     * @var PrettyPrinterAbstract
     */
    private $printer;

    /**
     * Constructor
     *
     * @param $cacheDir
     * @param Filesystem|null $filesystem
     * @param ClassModelTransformer $classModelTransformer
     * @param PrettyPrinterAbstract $printer
     */
    public function __construct($cacheDir, Filesystem $filesystem, ClassModelTransformer $classModelTransformer, PrettyPrinterAbstract $printer)
    {
        $this->cacheDir = $cacheDir;
        $this->filesystem = $filesystem;
        $this->classModelTransformer = $classModelTransformer;
        $this->printer = $printer;
    }

    /**
     * Write the model to a file
     *
     * @param ClassModel $classModel
     */
    public function write(ClassModel $classModel)
    {
        // create cache directory and get filename
        $path = $this->cacheDir . $this->namespaceToPath($classModel->getNamespace());
        $this->filesystem->mkdir($path);
        $filename = $path . DIRECTORY_SEPARATOR . $classModel->getName() . '.php';

        // convert class model to string
        $statements = $this->classModelTransformer->transform($classModel);
        $class = $this->printer->prettyPrint($statements);

        // write file
        $this->filesystem->dumpFile($filename, $class);
    }

    /**
     * Converts a namespace to a file path
     *
     * @param $namespace
     * @return string
     */
    private function namespaceToPath($namespace)
    {
        $path = explode('\\', $namespace);
        $path = implode(DIRECTORY_SEPARATOR, $path);

        return DIRECTORY_SEPARATOR . $path;
    }
}
