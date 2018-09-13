<?php

namespace TheFox\PersonsBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use TheFox\PersonsBundle\Entity\Person;
use TheFox\UserBundle\Entity\User;

class PersonVoter extends Voter
{
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::SHOW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Person) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
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

        switch ($attribute) {
            case self::SHOW:
            case self::EDIT:
            case self::DELETE:
                return $user->getId() === $person->getUser()->getId();
        }

        throw new \LogicException('This code should not be reached.');
    }
}
