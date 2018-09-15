<?php

namespace TheFox\PersonsBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use TheFox\PersonsBundle\Entity\Person;
use TheFox\UserBundle\Entity\User;

class PersonVoter extends Voter
{
    public const LIST = 'list';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    /**
     * @var string[]
     */
    private $attributes;

    public function __construct()
    {
        $this->attributes = [
            self::LIST,
            self::SHOW,
            self::EDIT,
            self::DELETE,
        ];
    }

    /**
     * @param string $attribute
     * @param Person $person
     * @return bool
     */
    protected function supports($attribute, $person)
    {
        if (!in_array($attribute, $this->attributes)) {
            return false;
        }

        if (null !== $person && !($person instanceof Person)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Person $person
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $person, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        if (!($user instanceof User)) {
            return false;
        }

        if (null !== $person) {
            $personUser = $person->getUser();
            if (null === $personUser) {
                return false;
            }
        }

        switch ($attribute) {
            case self::LIST:
                return true;

            case self::SHOW:
            case self::EDIT:
            case self::DELETE:
                $isSameUser = $user->getId() === $personUser->getId();
                $isNotDeleted = null === $person->getDeletedAt();
                $vote = $isSameUser && $isNotDeleted;

                return $vote;
        }

        throw new \LogicException('This code should not be reached.');
    }
}
