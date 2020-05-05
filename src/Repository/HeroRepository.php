<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Hero;

class HeroRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    ) {
        parent::__construct($registry, Hero::class);
        $this->manager = $manager;
    }

    public function create($name)
    {
        $newHero = new Hero($name);
        $this->manager->persist($newHero);
        $this->manager->flush();
        return $newHero;
    }

    public function update($hero)
    {
        $this->manager->persist($hero);
        $this->manager->flush();
        return $hero;
    }

    public function delete(Hero $hero)
    {
        $this->manager->remove($hero);
        $this->manager->flush();
        return true;
    }
}
