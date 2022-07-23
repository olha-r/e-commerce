<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($p = 0; $p < 100; $p++ ) {
            $product = new Product();
            $product
                ->setName($faker->sentence(3))
                ->setPrice($faker->numberBetween(20, 700))
                ->setSlug(strtolower($this->slugger->slug($product->getName())))
                ->setShortDescription($faker->text(150))
                ->setMainPicture($faker->imageUrl(360, 360));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
