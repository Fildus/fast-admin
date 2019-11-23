<?php

namespace DG\InstantAdminBundle;

use DG\InstantAdminBundle\Annotations\FastAdmin;
use Symfony\Component\Routing\Annotation\Route;

interface InstantAdminInterface
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     * @FastAdmin()
     *
     * @internal
     */
    public function index();

    /**
     * @Route("/new", name="_new", methods={"GET","POST"})
     * @FastAdmin()
     */
    public function new();

    /**
     * @Route("/{id}", name="_show", methods={"GET"})
     * @FastAdmin()
     */
    public function show();

    /**
     * @Route("/{id}/edit", name="_edit", methods={"GET","POST"})
     * @FastAdmin()
     */
    public function edit();

    /**
     * @Route("/{id}", name="_delete", methods={"DELETE"})
     * @FastAdmin()
     */
    public function delete();
}
