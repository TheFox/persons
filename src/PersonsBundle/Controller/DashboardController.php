<?php

namespace TheFox\PersonsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use TheFox\PersonsBundle\Repository\PersonRepository;
use TheFox\PersonsBundle\Security\Voter\PersonVoter;
use TheFox\PersonsBundle\Service\PersonService;

final class DashboardController extends BaseController
{
    public function indexAction(PersonRepository $personRepository, PersonService $personService): Response
    {
        // Security
        $this->denyAccessUnlessGranted(PersonVoter::LIST);

        $user = $this->getUser();
        $options = [
            'limit' => 5,
        ];

        // Recent Person New
        $options['order'] = [
            ['createdAt', 'DESC'],
        ];
        $recentPersonsNew = $personRepository->findByUser($user, $options);

        // Recent Person Update
        $options['order'] = [
            ['updatedAt', 'DESC'],
        ];
        $recentPersonsUpdates = $personRepository->findByUser($user, $options);

        // Upcoming Birthdays All
        $options['limit'] = 10;
        unset($options['order']);
        $upcomingBirthdaysAll = $personService->findUpcomingBirthdays($user, $options);

        // Upcoming Birthdays Alive
        $options['is_alive'] = true;
        $upcomingBirthdaysAlive = $personService->findUpcomingBirthdays($user, $options);

        // Upcoming Birthdays Dead
        $options['is_alive'] = false;
        $upcomingBirthdaysDead = $personService->findUpcomingBirthdays($user, $options);

        // Upcoming First Met Anniversaries Minor
        $upcomingFirstMetAnniversariesMinor = [];

        // Upcoming First Met Anniversaries Major
        $upcomingFirstMetAnniversariesMajor = [];

        // Youngest Persons All
        $youngestPersonsAll = [];

        // Youngest Persons Alive
        $youngestPersonsAlive = [];

        // Youngest Persons Dead
        $youngestPersonsDead = [];

        // Oldest Persons All
        $oldestPersonsAll = [];

        // Oldest Persons Alive
        $oldestPersonsAlive = [];

        // Oldest Persons Dead
        $oldestPersonsDead = [];

        // Form
        $data = [
            'recent_persons_new' => $recentPersonsNew,
            'recent_persons_updates' => $recentPersonsUpdates,

            'upcoming_birthdays_all' => $upcomingBirthdaysAll,
            'upcoming_birthdays_alive' => $upcomingBirthdaysAlive,
            'upcoming_birthdays_dead' => $upcomingBirthdaysDead,

            'upcoming_first_met_anniversaries_minor' => $upcomingFirstMetAnniversariesMinor,
            'upcoming_first_met_anniversaries_major' => $upcomingFirstMetAnniversariesMajor,

            'youngest_persons_all' => $youngestPersonsAll,
            'youngest_persons_alive' => $youngestPersonsAlive,
            'youngest_persons_dead' => $youngestPersonsDead,

            'oldest_persons_all' => $oldestPersonsAll,
            'oldest_persons_alive' => $oldestPersonsAlive,
            'oldest_persons_dead' => $oldestPersonsDead,
        ];
        $response = $this->render('dashboard/index.html.twig', $data);
        return $response;
    }
}
