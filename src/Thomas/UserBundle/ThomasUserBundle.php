<?php

namespace Thomas\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ThomasUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
