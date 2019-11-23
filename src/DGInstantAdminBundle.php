<?php

namespace DG\InstantAdminBundle;

use DG\InstantAdminBundle\DependencyInjection\InstantAdminExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DGInstantAdminBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new InstantAdminExtension();
    }
}
