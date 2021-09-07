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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="decimal", length=65)
     */
    private $order_by;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getOrderBy(): ?string
    {
        return $this->order_by;
    }

    public function setOrderBy(string $order_by): self
    {
        $this->order_by = $order_by;

        return $this;
    }
}
