<?php

namespace DG\InstantAdminBundle\Mapping;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use DG\InstantAdminBundle\Mapping\Model\Controller;
use DG\InstantAdminBundle\Mapping\Model\Method;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;

trait Mapping
{
    /**
     * @var array
     */
    private $mappedControllers = [];

    /**
     * @param $reader
     * @param $rootPath
     *
     * @throws \ReflectionException
     */
    public function setupControllers(Reader $reader, string $rootPath)
    {
        $finder = new Finder();
        $finder->files()->in($rootPath.'/Controller');

        $namespaces = [];

        foreach ($finder as $file) {
            $controllerPath = 'App\\Controller';
            $relativePath = ('' !== $file->getRelativePath()) && (null !== $file->getRelativePath()) ? '\\'.$file->getRelativePath() : null;
            $className = preg_filter('#([a-zA-Z]+Controller)\.php$#', '$1', $file->getBasename());
            if ($className) {
                $namespaces[] = $controllerPath.$relativePath.'\\'.$className;
            }
        }

        foreach ($namespaces as $namespace) {
            $controllerModel = new Controller();

            $controllerModel
                ->setNamespace($namespace);

            $classAnnotations = new \ReflectionClass($namespace);
            $classAnnotations = $reader->getClassAnnotations($classAnnotations);

            if (!empty($classAnnotations)) {
                foreach ($classAnnotations as $classAnnotation) {
                    if ($classAnnotation instanceof InstantAdmin) {
                        $controllerModel->setAdmin($classAnnotation);
                    }
                }
            }

            $methods = [];

            foreach (get_class_methods($namespace) as $method) {
                if (in_array($method, self::ALLOWED_METHODS)) {
                    $methodAnnotations = new \ReflectionMethod($namespace, $method);
                    $methodAnnotations = $reader->getMethodAnnotations($methodAnnotations);

                    $methodModel = new Method();
                    $methodModel->setName($method);

                    foreach ($methodAnnotations as $annotation) {
                        if ($annotation instanceof InstantAdmin) {
                            $methodModel->setAdminAnnotation($annotation);
                        }
                    }

                    $methods[$method] = $methodModel;
                }
            }

            $controllerModel->setMethods($methods);

            $this->mappedControllers[$namespace] = $controllerModel;
        }
    }
}
