<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{    
    /**
     * passwordHasher
     *
     * @var mixed
     */
    private $passwordHasher;
  
    /**
     * __construct
     *
     * @param  UserPasswordHasherInterface $passwordHasher passwordHasher
     * @return void
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    /**
     * load
     *
     * @param  ObjectManager $manager Manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Faker
        $faker = Factory::create('fr_FR');
        // To keep the same fixtures
        $faker->seed(2005);

        $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

        // User admin fixtures
        $admin = new User();

        $admin->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setImageProfile($faker->imageUrl());

        // Password hash
        $password = $this->passwordHasher->hashPassword($admin, 'azertyuiop');
        $admin->setPassword($password);

        $manager->persist($admin);

        // User fixtures
        for ($i = 0; $i < 10; $i++) {
            $user = new User();

            $user->setEmail('user' . $i . '@test.com')
                ->setRoles(['ROLE_USER'])
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setImageProfile($faker->imageUrl());

            // Password hash
            $password = $this->passwordHasher->hashPassword($user, 'azertyuiop');
            $user->setPassword($password);

            $manager->persist($user);
        }

        // Categories fixtures
        for ($l = 0; $l < 10; $l++) {
            $categorie = new Category();

            $categorie->setName($faker->word())
                ->setDescription($faker->words(10, true))
                ->setSlug($faker->slug());

            $manager->persist($categorie);

            // Figure fixture
            for ($m = 0; $m < 2; $m++) {
                $figure = new Figure();

                $figure->setName($faker->name())
                    ->setDescription($faker->text(350))
                    ->setCreatedBy($admin)
                    ->setCategory($categorie);

                $manager->persist($figure);

                // Image fixtures
                for ($j = 0; $j < 4; $j++) {
                    $image = new Image();

                    $image->setName($faker->imageUrl())
                        ->setFigure($figure);

                    $manager->persist($image);
                }

                // Video fixtures
                for ($k = 0; $k < 2; $k++) {
                    $video = new Video();

                    $video->setUrl($faker->url())
                        ->setFigure($figure);

                    $manager->persist($video);
                }

                // Comment fixtures
                for ($n = 0; $n < 4; $n++) {
                    $comment = new Comment();

                    $comment->setMessage($faker->text(50))
                        ->setCreatedBy($user)
                        ->setFigure($figure);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
