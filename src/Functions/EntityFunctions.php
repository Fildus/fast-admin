<?php

namespace DG\InstantAdminBundle\Functions;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;

class EntityFunctions
{
    /**
     * @throws AnnotationException
     * @throws \ReflectionException
     */
    public static function getEntityProperties(string $entityNamespace): array
    {
        $properties = [];

        $annotationReader = new AnnotationReader();
        $entityProperties = (new \ReflectionClass($entityNamespace))->getProperties();
        foreach ($entityProperties as $entityProperty) {
            if (self::isAnnotatedWithDoctrine($annotationReader->getPropertyAnnotations($entityProperty))) {
                $properties[] = $entityProperty;
            }
        }

        return $properties;
    }

    public static function isAnnotatedWithDoctrine(array $properties): bool
    {
        foreach ($properties as $property) {
            if (1 === preg_match('#^Doctrine\\\ORM\\\Mapping#', get_class($property))) {
                return true;
            }
        }

        return false;
    }
}
