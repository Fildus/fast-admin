<?php

namespace DG\InstantAdminBundle\Mapping\Model;

use DG\InstantAdminBundle\Annotations\InstantAdmin;

class Method
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var InstantAdmin
     */
    private $adminAnnotation;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdminAnnotation(): ?InstantAdmin
    {
        return $this->adminAnnotation;
    }

    public function setAdminAnnotation(InstantAdmin $adminAnnotation): self
    {
        $this->adminAnnotation = $adminAnnotation;

        return $this;
    }
}
