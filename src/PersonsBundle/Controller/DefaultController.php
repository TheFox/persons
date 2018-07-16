<?php

namespace TheFox\PersonsBundle\Controller;

final class DefaultController extends BaseController
{
    public function defaultAction()
    {
        return $this->render('base.html.twig');
    }
}
