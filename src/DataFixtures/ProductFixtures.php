<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Mmo\Faker\PicsumProvider;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));
        for ($p = 0; $p < 100; $p++ ) {
            $category = $this->getReference('category_'. rand( 1, 3 ));
            $product = new Product();
            $product
                ->setName($faker->words(3, true))
                ->setPrice($faker->numberBetween(20, 700))
                ->setSlug(strtolower($this->slugger->slug($product->getName())))
                ->setShortDescription($faker->text(150))
                ->setMainPicture($faker->imageUrl(400, 400, true))
                ->setCategory($category)
            ;
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,

        ];
    }
}
