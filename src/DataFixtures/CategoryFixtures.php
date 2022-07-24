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
            1 => [
                'name' => 'chaises'
            ],
            2 => [
                'name' => 'tables'
            ],
            3 => [
                'name' => 'lits'
            ],
        ];

        foreach ($categories as $key => $value) {
            $category = new Category();
            $category
                ->setName($value['name'])
                ->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        $manager->flush();

    }

}
