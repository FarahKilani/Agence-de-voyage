<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammationCircuitRepository")
 */
class ProgrammationCircuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nombrePersonnes;

    /**
     * @ORM\Column(type="smallint")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit")
     */
    private $circuit;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="ProgrammationCircuit")
     */
    private $liked_by;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="ReservationCircuit")
     */
    private $reserved_by;

    public function __construct()
    {
        $this->liked_by = new ArrayCollection();
        $this->reserved_by = new ArrayCollection();
    }
    
    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->nombrePersonnes;
    }

    public function setNombrePersonnes(int $nombrePersonnes): self
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuit $circuit): self
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikedBy(): Collection
    {
        return $this->liked_by;
    }

    public function addLikedBy(User $likedBy): self
    {
        if (!$this->liked_by->contains($likedBy)) {
            $this->liked_by[] = $likedBy;
            $likedBy->addProgrammationCircuit($this);
        }

        return $this;
    }

    public function removeLikedBy(User $likedBy): self
    {
        if ($this->liked_by->contains($likedBy)) {
            $this->liked_by->removeElement($likedBy);
            $likedBy->removeProgrammationCircuit($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getReservedBy(): Collection
    {
        return $this->reserved_by;
    }

    public function addReservedBy(User $reservedBy): self
    {
        if (!$this->reserved_by->contains($reservedBy)) {
            $this->reserved_by[] = $reservedBy;
            $reservedBy->addReservationCircuit($this);
        }

        return $this;
    }

    public function removeReservedBy(User $reservedBy): self
    {
        if ($this->reserved_by->contains($reservedBy)) {
            $this->reserved_by->removeElement($reservedBy);
            $reservedBy->removeReservationCircuit($this);
        }

        return $this;
    }
}
