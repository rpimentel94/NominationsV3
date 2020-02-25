<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sag_aftra_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $good_standing;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $signing_route;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $administration_code;

    /**
     * @ORM\Column(type="integer")
     */
    private $election_cycle_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $access_key;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="integer")
     */
    private $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSagAftraId(): ?int
    {
        return $this->sag_aftra_id;
    }

    public function setSagAftraId(?int $sag_aftra_id): self
    {
        $this->sag_aftra_id = $sag_aftra_id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
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

    public function getGoodStanding(): ?bool
    {
        return $this->good_standing;
    }

    public function setGoodStanding(?bool $good_standing): self
    {
        $this->good_standing = $good_standing;

        return $this;
    }

    public function getSigningRoute(): ?string
    {
        return $this->signing_route;
    }

    public function setSigningRoute(?string $signing_route): self
    {
        $this->signing_route = $signing_route;

        return $this;
    }

    public function getAdministrationCode(): ?string
    {
        return $this->administration_code;
    }

    public function setAdministrationCode(?string $administration_code): self
    {
        $this->administration_code = $administration_code;

        return $this;
    }

    public function getElectionCycleId(): ?int
    {
        return $this->election_cycle_id;
    }

    public function setElectionCycleId(int $election_cycle_id): self
    {
        $this->election_cycle_id = $election_cycle_id;

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

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDateCreated(): ?int
    {
        return $this->date_created;
    }

    public function setDateCreated(int $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function toArray()
    {
      return [
        'id' => $this->getId(),
        'sag_aftra_id' => $this->getSagAftraId(),
        'first_name' => $this->getFirstName(),
        'last_name' => $this->getLastName(),
        'full_name' => $this->getFullName(),
        'username' => $this->getUsername(),
        'good_standing' => $this->getGoodStanding(),
        'signing_route' => $this->getSigningRoute(),
        'administration_code' => $this->getAdministrationCode(),
        'election_cycle_id' => $this->getElectionCycleId(),
        'access_key' => $this->getAccessKey(),
        'active' => $this->getActive(),
        'date_created' => $this->getDateCreated(),
      ];
    }
}
