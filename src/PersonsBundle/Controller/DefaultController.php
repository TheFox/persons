<?php

namespace TheFox\PersonsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

final class DefaultController extends BaseController
{
    public function indexAction(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $response = $this->redirectToRoute('thefox_persons_frontend_dashboard');
            return $response;
        }

        return $this->render('@TheFoxPersons/default.html.twig');
    }
}
