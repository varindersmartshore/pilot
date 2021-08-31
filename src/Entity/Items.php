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
     * @ORM\Column(type="integer")
     */
    private $list_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $item_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListId(): ?int
    {
        return $this->list_id;
    }

    public function setListId(int $list_id): self
    {
        $this->list_id = $list_id;

        return $this;
    }

    public function getItemName(): ?string
    {
        return $this->item_name;
    }

    public function setItemName(string $item_name): self
    {
        $this->item_name = $item_name;

        return $this;
    }
}
