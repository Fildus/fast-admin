<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use DG\InstantAdminBundle\Model\Mapping\Controller;
use DG\InstantAdminBundle\Model\Mapping\Method;
use DG\InstantAdminBundle\Methods;
use DG\InstantAdminBundle\Workflow;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\Finder\Finder;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class AdminControllers
{
    private Reader $reader;
    private string $rootPath;
    private TagAwareCacheInterface $cache;

    public function __construct(Reader $reader, string $rootPath, TagAwareCacheInterface $cache)
    {
        $this->reader = $reader;
        $this->rootPath = $rootPath;
        $this->cache = $cache;
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function run(): bool
    {
        Workflow::getInstance()->setMappedControllers(
            $this->cache->get(
                'instant_admin_cache_mappedControllers',
                function (ItemInterface $item) {
                    $item->tag(['cache.app']);
                    $finder = new Finder();
                    $finder->files()->in($this->rootPath.'/src/Controller');

                    $mappedControllers = [];
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
                        $classAnnotations = $this->reader->getClassAnnotations($classAnnotations);

                        if (!empty($classAnnotations)) {
                            foreach ($classAnnotations as $classAnnotation) {
                                if ($classAnnotation instanceof InstantAdmin) {
                                    $controllerModel->setAdmin($classAnnotation);
                                }
                            }
                        }

                        $methods = [];

                        foreach (get_class_methods($namespace) as $method) {
                            if (in_array($method, Methods::ALLOWED_METHODS)) {
                                $methodAnnotations = new \ReflectionMethod($namespace, $method);
                                $methodAnnotations = $this->reader->getMethodAnnotations($methodAnnotations);

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
                })
        );

        return true;
    }
}
