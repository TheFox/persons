<?php

namespace TheFox\PersonsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Repository\PersonRepository;
use TheFox\PersonsBundle\Security\Voter\PersonVoter;

final class DashboardController extends BaseController
{
    public function indexAction(PersonRepository $personRepository): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::LIST);

        $user = $this->getUser();
        $persons = $personRepository->findByUser($user,5);

        // Form
        $data = [
            'recent_persons_new' => $persons,
            'recent_persons_updates' => $persons,

            'upcoming_birthdays_all' => $persons,
            'upcoming_birthdays_alive' => $persons,
            'upcoming_birthdays_dead' => $persons,

            'upcoming_first_met_anniversaries_minor' => $persons,
            'upcoming_first_met_anniversaries_major' => $persons,

            'youngest_persons_all' => $persons,
            'youngest_persons_alive' => $persons,
            'youngest_persons_dead' => $persons,

            'oldest_persons_all' => $persons,
            'oldest_persons_alive' => $persons,
            'oldest_persons_dead' => $persons,
        ];
        $response = $this->render('dashboard/index.html.twig', $data);
        return $response;
    }
}
