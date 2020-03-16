<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatementRepository")
 */
class Statement
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
    private $petition_id;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     */
    private $statement;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPetitionId(): ?int
    {
        return $this->petition_id;
    }

    public function setPetitionId(int $petition_id): self
    {
        $this->petition_id = $petition_id;

        return $this;
    }

    public function getStatement(): ?string
    {
        return $this->statement;
    }

    public function setStatement(?string $statement): self
    {
        $this->statement = $statement;

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
