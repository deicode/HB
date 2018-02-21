<?php

namespace Em\BackendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EmBackendBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
