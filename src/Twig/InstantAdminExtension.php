<?php

namespace DG\InstantAdminBundle\Twig;

use DG\InstantAdminBundle\Workflow;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class InstantAdminExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('dg_dismount', [$this, 'dg_dismount'], ['is_safe' => true]),
            new TwigFunction('dg_entityName', [$this, 'dg_entityName']),
            new TwigFunction('dg_pagination', [$this, 'dg_pagination']),
        ];
    }

    public function dg_dismount($entity, $metadata)
    {
        $array = [];
        foreach ($metadata as $item) {
            $value = $entity->{'get'.ucfirst($item['fieldName'])}();

            $value = (function () use ($value) {
                $value = $this->toString($value);
                if (strlen($value) > 18) {
                    $value = substr($value, 0, 15).'...';
                }

                return $this->toString($value);
            })();

            $array[$item['fieldName']] = $value;
        }

        return $array;
    }

    public function dg_entityName()
    {
        return (string) preg_match('#[a-zA-Z]+$#', Workflow::getInstance()->getEntityNamespace(), $matches) ? $matches[0] : '';
    }

    private function toString($value)
    {
        $string = '';
        if (is_string($value)) {
            $string .= $value;
        } elseif (is_integer($value)) {
            $string .= $value;
        } elseif (is_array($value)) {
            foreach ($value as $v) {
                $string .= $this->toString($v);
            }
        } elseif (is_a($value, \DateTime::class)) {
            /* @var \DateTime $value */
            $string .= $value->format('d-m-Y');
        } elseif (is_null($value)) {
            $string .= 'null';
        } elseif ($value instanceof \Doctrine\Common\Collections\Collection) {
            if ($value->isEmpty()) {
                $string .= 'null';
            } else {
                foreach ($value as $item) {
                    $string .= $this->toString($item);
                }
            }
        } elseif (method_exists($value, '__toString')) {
            $string .= $value->__toString();
        } else {
            dd(__CLASS__, $value);
        }

        return $string;
    }

    public function dg_pagination()
    {
    }
}
