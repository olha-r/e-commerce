<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            1 => 'chaises',
            2 => 'tables',
            3 => 'lits'
        ];

        for ($c = 1; $c < 4; $c++) {
            $category = new Category();
            $category
                ->setName($categories[$c])
                ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
        }
        $manager->flush();
    }
}
