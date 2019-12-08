<?php

namespace DG\InstantAdminBundle\Mapping\Model;

use DG\InstantAdminBundle\Annotations\InstantAdmin;

class Method
{
    private string $name;
    private InstantAdmin $adminAnnotation;

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
