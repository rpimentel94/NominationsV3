<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionBoardPositionsRepository")
 */
class ElectionBoardPositions
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
    private $election_cycles_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $election_boards_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position_2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additional_notes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $signatures_required;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $delegate;

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

    public function setElectionCyclesId(int $election_cycles_id): self
    {
        $this->election_cycles_id = $election_cycles_id;

        return $this;
    }

    public function getElectionBoardsId(): ?int
    {
        return $this->election_boards_id;
    }

    public function setElectionBoardsId(?int $election_boards_id): self
    {
        $this->election_boards_id = $election_boards_id;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPosition2(): ?string
    {
        return $this->position_2;
    }

    public function setPosition2(?string $position_2): self
    {
        $this->position_2 = $position_2;

        return $this;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additional_notes;
    }

    public function setAdditionalNotes(?string $additional_notes): self
    {
        $this->additional_notes = $additional_notes;

        return $this;
    }

    public function getSignaturesRequired(): ?int
    {
        return $this->signatures_required;
    }

    public function setSignaturesRequired(?int $signatures_required): self
    {
        $this->signatures_required = $signatures_required;

        return $this;
    }

    public function getDelegate(): ?bool
    {
        return $this->delegate;
    }

    public function setDelegate(?bool $delegate): self
    {
        $this->delegate = $delegate;

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
