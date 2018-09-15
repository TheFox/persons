<?php

namespace TheFox\PersonsBundle\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TheFox\PersonsBundle\Repository\EventRepository")
 * @ORM\Table(name="persons2_events", indexes={
 *     @ORM\Index(columns={"deleted_at"}),
 * })
 * @ORM\HasLifecycleCallbacks()
 */
final class Event
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="happened_at", type="datetime", nullable=true)
     */
    private $happenedAt;

    /**
     * @var int
     * @ORM\Column(name="type", type="smallint", options={"unsigned": true, "default": 1000})
     */
    private $type;

    /**
     * @var string|null
     * @ORM\Column(name="place", type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @var string|null
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

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

    /**
     * @var Person
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="events")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    public function __construct()
    {
        $this->createdAt = Carbon::now('UTC');
    }

    public function __toString()
    {
        if (null === $this->id) {
            return 'Event';
        }
        return sprintf('Event %d', $this->id);
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->updatedAt = Carbon::now('UTC');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime|null
     */
    public function getHappenedAt(): ?\DateTime
    {
        return $this->happenedAt;
    }

    /**
     * @param \DateTime|null $happenedAt
     */
    public function setHappenedAt(?\DateTime $happenedAt): void
    {
        $this->happenedAt = $happenedAt;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param null|string $place
     */
    public function setPlace(?string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }
}
