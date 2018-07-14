<?php

namespace TheFox\PersonsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TheFox\PersonsBundle\Repository\PersonRepository")
 * @ORM\Table(name="persons2_persons", indexes={
 *     @ORM\Index(columns={"deleted_at"})
 * })
 */
class Person
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string|null
     * @ORM\Column(name="last_name_born", type="string", length=255, nullable=true)
     */
    private $lastNameBorn;

    /**
     * @var string|null
     * @ORM\Column(name="middle_name", type="string", length=255, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(name="nick_name", type="string", length=255, nullable=true)
     */
    private $nickName;

    /**
     * @var string|null
     * @ORM\Column(name="gender", type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="birthday", type="datetime", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="deceased_at", type="datetime", nullable=true)
     */
    private $deceasedAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="first_met_at", type="datetime", nullable=true)
     */
    private $firstMetAt;

    /**
     * @var string|null
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @var string|null
     * @ORM\Column(name="facebook_url", type="text", nullable=true)
     */
    private $facebookUrl;

    /**
     * @var string|null
     * @ORM\Column(name="blood_type", type="string", length=2, nullable=true)
     */
    private $bloodType;

    /**
     * @var string|null
     * @ORM\Column(name="blood_type_rhd", type="string", length=1, nullable=true)
     */
    private $bloodTypeRhd;

    /**
     * @var int|null
     * @ORM\Column(name="default_event_type", type="smallint", nullable=true, options={"default": 1000})
     */
    private $defaultEventType;

    /**
     * @var string|null
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return null|string
     */
    public function getLastNameBorn(): ?string
    {
        return $this->lastNameBorn;
    }

    /**
     * @param null|string $lastNameBorn
     */
    public function setLastNameBorn(?string $lastNameBorn): void
    {
        $this->lastNameBorn = $lastNameBorn;
    }

    /**
     * @return null|string
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param null|string $middleName
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return null|string
     */
    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    /**
     * @param null|string $nickName
     */
    public function setNickName(?string $nickName): void
    {
        $this->nickName = $nickName;
    }

    /**
     * @return null|string
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param null|string $gender
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime|null $birthday
     */
    public function setBirthday(?\DateTime $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeceasedAt(): ?\DateTime
    {
        return $this->deceasedAt;
    }

    /**
     * @param \DateTime|null $deceasedAt
     */
    public function setDeceasedAt(?\DateTime $deceasedAt): void
    {
        $this->deceasedAt = $deceasedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getFirstMetAt(): ?\DateTime
    {
        return $this->firstMetAt;
    }

    /**
     * @param \DateTime|null $firstMetAt
     */
    public function setFirstMetAt(?\DateTime $firstMetAt): void
    {
        $this->firstMetAt = $firstMetAt;
    }

    /**
     * @return null|string
     */
    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    /**
     * @param null|string $facebookId
     */
    public function setFacebookId(?string $facebookId): void
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return null|string
     */
    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    /**
     * @param null|string $facebookUrl
     */
    public function setFacebookUrl(?string $facebookUrl): void
    {
        $this->facebookUrl = $facebookUrl;
    }

    /**
     * @return null|string
     */
    public function getBloodType(): ?string
    {
        return $this->bloodType;
    }

    /**
     * @param null|string $bloodType
     */
    public function setBloodType(?string $bloodType): void
    {
        $this->bloodType = $bloodType;
    }

    /**
     * @return null|string
     */
    public function getBloodTypeRhd(): ?string
    {
        return $this->bloodTypeRhd;
    }

    /**
     * @param null|string $bloodTypeRhd
     */
    public function setBloodTypeRhd(?string $bloodTypeRhd): void
    {
        $this->bloodTypeRhd = $bloodTypeRhd;
    }

    /**
     * @return int|null
     */
    public function getDefaultEventType(): ?int
    {
        return $this->defaultEventType;
    }

    /**
     * @param int|null $defaultEventType
     */
    public function setDefaultEventType(?int $defaultEventType): void
    {
        $this->defaultEventType = $defaultEventType;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime|null $deletedAt
     */
    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
