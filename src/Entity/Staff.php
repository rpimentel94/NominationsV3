<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 */
class Staff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $election;

    /**
     * @ORM\Column(type="integer")
     */
    private $election_cycles_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_modified;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $access_key;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getElection(): ?string
    {
        return $this->election;
    }

    public function setElection(?string $election): self
    {
        $this->election = $election;

        return $this;
    }

    public function getElectionCyclesId(): ?int
    {
        return $this->election_cycles_id;
    }

    public function setElectionCyclesId(int $election_cycles_id): self
    {
        $this->election_cycles_id = $election_cycles_id;

        return $this;
    }

    public function getDateCreated(): ?string
    {
        return $this->date_created;
    }

    public function setDateCreated(?string $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateModified(): ?string
    {
        return $this->date_modified;
    }

    public function setDateModified(?string $date_modified): self
    {
        $this->date_modified = $date_modified;

        return $this;
    }

    public function getAccessKey(): ?string
    {
        return $this->access_key;
    }

    public function setAccessKey(?string $access_key): self
    {
        $this->access_key = $access_key;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
