<?php

namespace TheFox\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TheFox\UserBundle\Repository\GroupRepository")
 * @ORM\Table(name="persons2_fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
