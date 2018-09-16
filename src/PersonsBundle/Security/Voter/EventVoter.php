<?php

namespace TheFox\PersonsBundle\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use TheFox\PersonsBundle\Entity\Event;
use TheFox\UserBundle\Entity\User;

class EventVoter extends Voter
{
    public const NEW = 'new';
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    /**
     * @var PersonVoter
     */
    private $personVoter;

    /**
     * @var string[]
     */
    private $attributes;

    public function __construct(PersonVoter $personVoter)
    {
        $this->attributes = [
            self::NEW,
            self::SHOW,
            self::EDIT,
            self::DELETE,
        ];

        $this->personVoter = $personVoter;
    }

    /**
     * @param string $attribute
     * @param Event $event
     * @return bool
     */
    protected function supports($attribute, $event)
    {
        if (!($event instanceof Event)) {
            return false;
        }
        if (!in_array($attribute, $this->attributes)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Event $event
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $event, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        if (!($user instanceof User)) {
            return false;
        }

        $person = $event->getPerson();
        $personVoterRes = $this->personVoter->vote($token, $person, [PersonVoter::EDIT]);
        if (VoterInterface::ACCESS_DENIED === $personVoterRes) {
            return false;
        }

        if ($event->getDeletedAt()) {
            return false;
        }

        return true;
    }
}
