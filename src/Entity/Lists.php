<?php

namespace App\Entity;

use App\Repository\ListsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ListsRepository::class)
 */
class Lists
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $list_name;

    /**
     * @Assert\NotBlank
     * @ORM\OneToMany(targetEntity=Items::class, mappedBy="list_id", orphanRemoval=true)
     * @ORM\OrderBy({"order_by"="ASC"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListName(): ?string
    {
        return $this->list_name;
    }

    public function setListName(?string $list_name): self
    {
        $this->list_name = $list_name;

        return $this;
    }

    /**
     * @return Collection|Items[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Items $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setListId($this);
        }

        return $this;
    }

    public function removeItem(Items $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getListId() === $this) {
                $item->setListId(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
