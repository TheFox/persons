<?php

namespace TheFox\PersonsBundle\Controller;

final class DefaultController extends BaseController
{
    public function aboutAction()
    {
        return $this->render('base.html.twig');
    }
}
