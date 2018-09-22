<?php

namespace TheFox\PersonsBundle\Service;

use Carbon\Carbon;
use TheFox\PersonsBundle\Repository\PersonRepository;
use TheFox\UserBundle\Entity\User;

class PersonService
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @param User $user
     * @param array $options
     * @return array[]
     */
    public function findUpcomingBirthdays(User $user, array $options = []): array
    {
        $rawPersons = $this->personRepository->findUpcomingBirthdays($user, $options);

        $now = Carbon::today();

        $htmlPersons = [];
        foreach ($rawPersons as $person) {
            $birthday = $person->getBirthday();
            $age = $now->year - $birthday->format('Y');

            $birthdayThisYearStr = sprintf('%s-%s', $now->format('Y'), $birthday->format('m-d'));
            $birthdayThisYear = new Carbon($birthdayThisYearStr);
            $diff = $birthdayThisYear->diff($now);

            $diffInt = intval($diff->format('%R%a'));
            if ($diffInt == 0) {
                $diffStr = 'Today';
            } else {
                $diffStr = $diff->format('%R%a days');
            }

            if ($diffInt >= -14 && $diffInt <= 0) {
                $diffColor = '#006400';
            } elseif ($diffInt < -14) {
                $diffColor = '#ff8c00';
            } else {
                $diffColor = '';
            }

            $htmlPersons[] = [
                'person' => $person,
                'attr' => [
                    'id' => $person->getId(),
                    'diff' => $diffStr,
                    'diff_color' => $diffColor,
                    'age' => $age,
                ],
            ];
        }
        return $htmlPersons;
    }
}
