<?php

namespace DG\InstantAdminBundle\Mapping;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use DG\InstantAdminBundle\Mapping\Model\Controller;
use DG\InstantAdminBundle\Mapping\Model\Method;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function setupControllers(Reader $reader, string $rootPath, TagAwareCacheInterface $cache)
    {
        $this->mappedControllers = $cache->get(
            'instant_admin_cache_mappedControllers',
            function (ItemInterface $item) use ($rootPath, $reader) {
                $item->tag(['cache.app']);

                $mappedControllers = [];

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

                    $mappedControllers[$namespace] = $controllerModel;
                }

                return $mappedControllers;
            });
    }
}
