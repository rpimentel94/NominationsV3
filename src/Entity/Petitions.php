<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PetitionsRepository")
 */
class Petitions
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
     * @ORM\Column(type="integer")
     */
    private $election_cycles_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $election_boards_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $election_board_positions_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $consent_to_serve;

    /**
     * @ORM\Column(type="boolean")
     */
    private $agreement_signature;

    /**
     * @ORM\Column(type="boolean")
     */
    private $lmrda_notice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $photo_release;

    /**
     * @ORM\Column(type="boolean")
     */
    private $withdrawn;

    /**
     * @ORM\Column(type="boolean")
     */
    private $preliminary_eligibility_check;

    /**
     * @ORM\Column(type="boolean")
     */
    private $final_eligibility;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online_signature_status;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $national;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $date_created;

    /**
     * @ORM\Column(type="string", length=50)
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

    public function setElectionBoardsId(int $election_boards_id): self
    {
        $this->election_boards_id = $election_boards_id;

        return $this;
    }

    public function getElectionBoardPositionsId(): ?int
    {
        return $this->election_board_positions_id;
    }

    public function setElectionBoardPositionsId(int $election_board_positions_id): self
    {
        $this->election_board_positions_id = $election_board_positions_id;

        return $this;
    }

    public function getConsentToServe(): ?bool
    {
        return $this->consent_to_serve;
    }

    public function setConsentToServe(bool $consent_to_serve): self
    {
        $this->consent_to_serve = $consent_to_serve;

        return $this;
    }

    public function getAgreementSignature(): ?bool
    {
        return $this->agreement_signature;
    }

    public function setAgreementSignature(bool $agreement_signature): self
    {
        $this->agreement_signature = $agreement_signature;

        return $this;
    }

    public function getLmrdaNotice(): ?bool
    {
        return $this->lmrda_notice;
    }

    public function setLmrdaNotice(bool $lmrda_notice): self
    {
        $this->lmrda_notice = $lmrda_notice;

        return $this;
    }

    public function getPhotoRelease(): ?bool
    {
        return $this->photo_release;
    }

    public function setPhotoRelease(bool $photo_release): self
    {
        $this->photo_release = $photo_release;

        return $this;
    }

    public function getWithdrawn(): ?bool
    {
        return $this->withdrawn;
    }

    public function setWithdrawn(bool $withdrawn): self
    {
        $this->withdrawn = $withdrawn;

        return $this;
    }

    public function getPreliminaryEligibilityCheck(): ?bool
    {
        return $this->preliminary_eligibility_check;
    }

    public function setPreliminaryEligibilityCheck(bool $preliminary_eligibility_check): self
    {
        $this->preliminary_eligibility_check = $preliminary_eligibility_check;

        return $this;
    }

    public function getFinalEligibility(): ?bool
    {
        return $this->final_eligibility;
    }

    public function setFinalEligibility(bool $final_eligibility): self
    {
        $this->final_eligibility = $final_eligibility;

        return $this;
    }

    public function getOnlineSignatureStatus(): ?bool
    {
        return $this->online_signature_status;
    }

    public function setOnlineSignatureStatus(bool $online_signature_status): self
    {
        $this->online_signature_status = $online_signature_status;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getNational(): ?bool
    {
        return $this->national;
    }

    public function setNational(?bool $national): self
    {
        $this->national = $national;

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
