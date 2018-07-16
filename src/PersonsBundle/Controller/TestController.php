<?php

namespace TheFox\PersonsBundle\Controller;

final class TestController extends BaseController
{
    public function testFlashAction()
    {
        // Flash Messages
        $session = $this->get('session');
        $flashBag = $session->getFlashBag();

        $flashBag->add('notice', 'Test OK');

        $this->addFlash('notice', 'Test2');

        return $this->redirectToRoute('thefox_persons_frontend_index');
    }
}
