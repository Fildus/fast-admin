<?php

namespace DG\InstantAdminBundle\Mapping\Model;

use DG\InstantAdminBundle\Annotations\InstantAdmin;

class Controller
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var InstantAdmin
     */
    private $adminAnnotation;

    /**
     * @var array
     */
    private $methods;

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getAdmin(): ? InstantAdmin
    {
        return $this->adminAnnotation;
    }

    public function setAdmin(InstantAdmin $adminAnnotation): self
    {
        $this->adminAnnotation = $adminAnnotation;

        return $this;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function setMethods(array $methods): self
    {
        $this->methods = $methods;

        return $this;
    }
}
