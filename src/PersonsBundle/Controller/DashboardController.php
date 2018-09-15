<?php

namespace TheFox\PersonsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Security\Voter\PersonVoter;

final class DashboardController extends BaseController
{
    public function indexAction(): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::LIST);

        // Form
        $data = [
            'recent_persons_new' => [],
            'recent_persons_updates' => [],

            'upcoming_birthdays_all' => [],
            'upcoming_birthdays_alive' => [],
            'upcoming_birthdays_dead' => [],

            'upcoming_first_met_anniversaries_minor' => [],
            'upcoming_first_met_anniversaries_major' => [],

            'youngest_persons_all' => [],
            'youngest_persons_alive' => [],
            'youngest_persons_dead' => [],

            'oldest_persons_all' => [],
            'oldest_persons_alive' => [],
            'oldest_persons_dead' => [],
        ];
        $response = $this->render('@TheFoxPersons/dashboard/index.html.twig', $data);
        return $response;
    }
}
