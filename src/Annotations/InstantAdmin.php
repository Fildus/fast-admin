<?php

namespace DG\InstantAdminBundle\Annotations;

/**
 * Annotation class for @InstantAdmin().
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 *
 * @author David GASTALDELLO <davidgastaldello@msn.com>
 */
class InstantAdmin
{
    public ?string $template;
    public ?string $formType;
    public ?bool $pagination;
    public ?string $redirectAfterSubmit;

    public function __construct()
    {
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function setFormType(?string $formType): self
    {
        $this->formType = $formType;

        return $this;
    }

    /**
     * @return bool|int|null
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param bool|int|null $pagination
     *
     * @return InstantAdmin
     */
    public function setPagination($pagination)
    {
        $this->pagination = $pagination;

        return $this;
    }

    public function getRedirectAfterSubmit(): ?string
    {
        return $this->redirectAfterSubmit;
    }

    public function setRedirectAfterSubmit(?string $redirectAfterSubmit): self
    {
        $this->redirectAfterSubmit = $redirectAfterSubmit;

        return $this;
    }
}
