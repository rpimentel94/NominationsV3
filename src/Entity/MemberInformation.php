<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberInformationRepository")
 */
class MemberInformation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $users_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ballot_display_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $media_contact;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $media_phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $media_email;

    /**
     * @ORM\Column(type="integer")
     */
    private $election_cycles_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $date_created;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $date_modified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersId(): ?int
    {
        return $this->users_id;
    }

    public function setUsersId(int $users_id): self
    {
        $this->users_id = $users_id;

        return $this;
    }

    public function getBallotDisplayName(): ?string
    {
        return $this->ballot_display_name;
    }

    public function setBallotDisplayName(?string $ballot_display_name): self
    {
        $this->ballot_display_name = $ballot_display_name;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(?string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getMediaContact(): ?bool
    {
        return $this->media_contact;
    }

    public function setMediaContact(?bool $media_contact): self
    {
        $this->media_contact = $media_contact;

        return $this;
    }

    public function getMediaPhone(): ?string
    {
        return $this->media_phone;
    }

    public function setMediaPhone(?string $media_phone): self
    {
        $this->media_phone = $media_phone;

        return $this;
    }

    public function getMediaEmail(): ?string
    {
        return $this->media_email;
    }

    public function setMediaEmail(?string $media_email): self
    {
        $this->media_email = $media_email;

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

    public function getDateModified(): ?string
    {
        return $this->date_modified;
    }

    public function setDateModified(string $date_modified): self
    {
        $this->date_modified = $date_modified;

        return $this;
    }
}
