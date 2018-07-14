<?php

namespace TheFox\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class TheFoxUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
