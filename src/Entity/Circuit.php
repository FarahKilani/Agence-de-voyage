<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CircuitRepository")
 */
class Circuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $paysDepart;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $villeDepart;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $villeArrivee;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $dureeCircuit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etape", mappedBy="circuit", orphanRemoval=true)
     */
    private $etapes;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgrammationCircuit", mappedBy="circuit", orphanRemoval=true)
     */
    private $programmation;
    
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $url;
    
    

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
        $this->programmation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPaysDepart(): ?string
    {
        return $this->paysDepart;
    }

    public function setPaysDepart(?string $paysDepart): self
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(?string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrivee(): ?string
    {
        return $this->villeArrivee;
    }

    public function setVilleArrivee(?string $villeArrivee): self
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    public function getDureeCircuit(): ?int
    {
        return $this->dureeCircuit;
    }

    public function setDureeCircuit(?int $dureeCircuit): self
    {
        $this->dureeCircuit = $dureeCircuit;

        return $this;
    }

    /**
     * @return Collection|Etape[]
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setCircuit($this);
        }

        return $this;
    }
    public function getProgrammation(): Collection
    {
        return $this->programmation;        
    }
    
    public function addProgrammation(ProgrammationCircuit $prog): self
    {
        if(!$this->programmation->contains($prog)){
            
            $this->programmation[] = $prog;
            $prog->setCircuit($this);
//             array_push($this->programmation,$prog);
        }
        return $this;        
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->contains($etape)) {
            $this->etapes->removeElement($etape);
            // set the owning side to null (unless already changed)
            if ($etape->getCircuit() === $this) {
                $etape->setCircuit(null);
            }
        }
        
        return $this;
    }
    
    public function getUrl(): ?string
    {
        return $this->url;
    }
    
    public function setUrl(string $url): self
    {
        $this->url=$url;
        return $this;
    }
    
    
    public function __toString() {
        return (string) $this->getId();
    }
}
