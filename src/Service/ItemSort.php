<?php

namespace App\Service;

// use Symfony\Bridge\Doctrine\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Items;
use App\Entity\Lists;

class ItemSort
{
    protected $mr;

    public function __construct(ManagerRegistry $mr)
	{
		$this->mr = $mr;
	}

    public function sortByOrder($listId): array
    {
        $em = $this->mr->getManagerForClass(get_class(new Items()));
        $result = $em->getRepository(Items::class)->findByListIdGetOrderBy($listId);
        return $result;
    }
}