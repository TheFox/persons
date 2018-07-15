<?php

namespace TheFox\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TheFox\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="persons2_fos_user", indexes={
 *     @ORM\Index(columns={"old_id"}),
 * })
 */
final class User extends BaseUser
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="persons2_fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @TODO remove after all migrations are done
     * @var int
     * @ORM\Column(name="old_id", type="integer", nullable=true)
     */
    private $oldId;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="TheFox\PersonsBundle\Entity\Person", mappedBy="user")
     */
    private $persons;

    public function __construct()
    {
        parent::__construct();

        $this->persons=new ArrayCollection();
    }

    public function __toString()
    {
        if (null === $this->id) {
            return 'User';
        }
        return sprintf('User %d',$this->id);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getPersons(): ArrayCollection
    {
        return $this->persons;
    }

    /**
     * @param ArrayCollection $persons
     */
    public function setPersons(ArrayCollection $persons): void
    {
        $this->persons = $persons;
    }
}
