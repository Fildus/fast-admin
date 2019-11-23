<?php

namespace DG\InstantAdminBundle\Twig;

use Symfony\Component\Validator\Constraints\Collection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class InstantAdminExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('dg_getType', [$this, 'dg_getType']),
            new TwigFunction('dg_dismount', [$this, 'dg_dismount']),
        ];
    }

    public function dg_getType($value)
    {
        if ($value instanceof \DateTime) {
            return 'datetime';
        }
        if ($value instanceof Collection) {
            return 'collection';
        }
        if ($value instanceof \Doctrine\Common\Collections\Collection) {
            return 'collection';
        }
        if (null === $value) {
            return 'null';
        }
        if (is_array($value)) {
            return 'array';
        }
        if (is_string($value)) {
            return 'string';
        }
        if (is_integer($value)) {
            return 'integer';
        }
        if (is_object($value)) {
            return 'object';
        }

        throw new \ErrorException(__CLASS__.' $value not reconized');
    }

    /**
     * @param $object
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function dg_dismount($object)
    {
        $reflectionClass = new \ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $array;
    }
}
