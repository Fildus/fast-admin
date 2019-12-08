<?php

namespace DG\InstantAdminBundle;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use Symfony\Component\Routing\Annotation\Route;

trait InstantAdminMethods
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     * @InstantAdmin()
     */
    public function index()
    {
    }

    /**
     * @Route("/new", name="_new", methods={"GET","POST"})
     * @InstantAdmin()
     */
    public function new()
    {
    }

    /**
     * @Route("/{id}", name="_show", methods={"GET"})
     * @InstantAdmin()
     */
    public function show()
    {
    }

    /**
     * @Route("/{id}/edit", name="_edit", methods={"GET","POST"})
     * @InstantAdmin()
     */
    public function edit()
    {
    }

    /**
     * @Route("/{id}", name="_delete", methods={"DELETE"})
     * @InstantAdmin()
     */
    public function delete()
    {
    }
}
