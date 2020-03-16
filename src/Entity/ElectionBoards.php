<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionBoardsRepository")
 */
class ElectionBoards
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
    private $election_cycles_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $boards_name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $date_start;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $address_1;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $address_2;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private $important_note;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $locals_code;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElectionCyclesId(): ?int
    {
        return $this->election_cycles_id;
    }

    public function setElectionCyclesId(?int $election_cycles_id): self
    {
        $this->election_cycles_id = $election_cycles_id;

        return $this;
    }

    public function getBoardsName(): ?string
    {
        return $this->boards_name;
    }

    public function setBoardsName(string $boards_name): self
    {
        $this->boards_name = $boards_name;

        return $this;
    }

    public function getDateStart(): ?string
    {
        return $this->date_start;
    }

    public function setDateStart(?string $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?string
    {
        return $this->date_end;
    }

    public function setDateEnd(?string $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address_1;
    }

    public function setAddress1(?string $address_1): self
    {
        $this->address_1 = $address_1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address_2;
    }

    public function setAddress2(?string $address_2): self
    {
        $this->address_2 = $address_2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getImportantNote(): ?string
    {
        return $this->important_note;
    }

    public function setImportantNote(?string $important_note): self
    {
        $this->important_note = $important_note;

        return $this;
    }

    public function getLocalsCode(): ?string
    {
        return $this->locals_code;
    }

    public function setLocalsCode(?string $locals_code): self
    {
        $this->locals_code = $locals_code;

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

    public function getDateCreated(): ?string
    {
        return $this->date_created;
    }

    public function setDateCreated(string $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }
}
