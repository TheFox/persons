<?php

namespace TheFox\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TheFox\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="persons2_fos_user", indexes={
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
     * @var int
     * @ORM\Column(name="old_id", type="integer", nullable=true)
     */
    private $oldId;

    public function __construct()
    {
        parent::__construct();
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
}
