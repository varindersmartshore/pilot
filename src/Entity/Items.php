<?php

namespace App\Entity;

use App\Repository\ItemsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemsRepository::class)
 */
class Items
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
    private $item_name;

    /**
     * @ORM\ManyToOne(targetEntity=Lists::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $list_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemName(): ?string
    {
        return $this->item_name;
    }

    public function setItemName(?string $item_name): self
    {
        $this->item_name = $item_name;

        return $this;
    }

    public function getListId(): ?Lists
    {
        return $this->list_id;
    }

    public function setListId(?Lists $list_id): self
    {
        $this->list_id = $list_id;

        return $this;
    }
}
