<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Multimedia;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;


    public function __construct(UserPasswordHasherInterface $encoder, )
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        $this->loadVehicle($manager);
        $this->loadUserInfo($manager);
        $this->loadAddress($manager);
        $this->loadUser($manager);
        $manager->flush();
    }

//    public function loadUser(ObjectManager $manager): void
//    {
//
//        $userArr = [
//            ['email' => 'toto@toto.com', 'roles' => ['ROLES_USER'], 'password' => '1234', 'isActive' => 1, 'isVerified' => 0],
//            ['email' => 'admin@admin.com', 'roles' => ['ROLES_ADMIN'], 'password' => 'admin', 'isActive' => 1, 'isVerified' => 1]
//        ];
//
//        $faker = Factory::create('fr_FR');
//        $post = new Post();
//
//
//        foreach ($userArr as $key => $value){
//            for ($question = 1 ; $question <=20; $question++){
//                $user = new User();
//
//                $post->setTitle($faker->title)
//                    ->setCreatedAt($faker->dateTime('now'))
//                    ->setIsActive(true)
//                    ->setUserPost($user)
//                    ->setDescription($faker->text(150));
//                $manager->persist($post);
//            }
//            $user->setEmail($value['email'])
//                 ->setRoles($value['roles'])
//                 ->setIsActive($value['isActive'])
//                 ->setPassword($this->encoder->hashPassword($user, $value['password']))
//                 ->setCreatedAt(new \DateTime('now'))
//                 ->setIsVerified($value['isVerified'])
//                 ->setIsAgree(true)
//                 ->setUserInfo($this->getReference('userInfo - ' . $key +1 ))
//                 ->setAddress($this->getReference('address - ' . $key +1));
//
//            $manager->persist($user);
//
//            $this->addReference('user - ' . $key +1 , $user);
//        }






   // }

    public function loadVehicle(ObjectManager $manager): void
    {
        $VehicleArr = [
            ['vehicle' => 'Automobile',     'slug' => 'automobile'],
            ['vehicle' => 'Motocycle',      'slug' => 'motocycle'],
            ['vehicle' => 'Poid Lourd',     'slug' => 'poid-lourd'],
            ['vehicle' => 'Engin Nautique', 'slug' => 'engin-nautique'],
            ['vehicle' => 'Engin Agricole', 'slug' => 'engin-agricole'],
            ['vehicle' => 'Aviation',       'slug' => 'aviation']
        ];

        foreach ($VehicleArr as $key => $value){
            $vehicle = new Vehicle();

            $vehicle->setVehicle($value['vehicle'])
                ->setSlug($value['slug']);


            $manager->persist($vehicle);

            $this->addReference('vehicle - ' . $key+1, $vehicle);

        }

        $manager->flush();
    }

    public function loadUser(ObjectManager $manager): void
    {

        $userArr = [
            ['email' => 'toto@toto.com', 'roles' => ['ROLES_USER'], 'password' => '1234', 'isActive' => 1, 'isVerified' => 0],
            ['email' => 'admin@admin.com', 'roles' => ['ROLES_ADMIN'], 'password' => 'admin', 'isActive' => 1, 'isVerified' => 1]
        ];

        $faker = Factory::create('fr_FR');

        foreach ($userArr as $key => $value) {
            $user = new User();
            $img = new Multimedia();
            $user->setEmail($value['email'])
                ->setRoles($value['roles'])
                ->setIsActive($value['isActive'])
                ->setPassword($this->encoder->hashPassword($user, $value['password']))
                ->setCreatedAt(new \DateTime('now'))
                ->setIsVerified($value['isVerified'])
                ->setIsAgree(true)
                ->setUserInfo($this->getReference('userInfo - ' . ($key + 1)))
                ->setAddress($this->getReference('address - ' . ($key + 1)))
                ->setProfilePicture(
                    $img->setImageProfile($faker->imageUrl(80, 80, 'user', true, true)
                ));
            $img->setIsActive(true);
            $manager->persist($img);
            $manager->persist($user);

            $this->addReference('user - ' . ($key + 1), $user);
        }

        $manager->flush();
    }

    public function loadUserInfo(ObjectManager $manager): void
    {

        $userInfoArr = [
            ['pseudo' => 'toto', 'lastname' => 'tutu', 'firstname' => 'totu', 'phone' => '00.01.02.05.06'],
            ['pseudo' => 'admin', 'lastname' => 'admin Toto', 'firstname' => 'Paul', 'phone' => '87.78.45.25.10']
        ];

        foreach ($userInfoArr as $key => $info){
            $userInfo = new UserInfo();

            $userInfo->setPseudo($info['pseudo'])
                     ->setLastname($info['lastname'])
                     ->setFirstname($info['firstname'])
                     ->setPhone($info['phone']);

            $manager->persist($userInfo);

            $this->addReference('userInfo - ' . $key +1, $userInfo);
        }



    }

    public function loadAddress(ObjectManager $manager): void
    {

        $addressArr = [
            ['city' => 'berlin', 'country' => 'allemagne', 'postalCode' => '345612'],
            ['city' => 'madrid', 'country' => 'espagne', 'postalCode' => '100021']
        ];

        foreach ($addressArr as $key => $value){
            $address = new Address();

            $address->setCity($value['city'])
                    ->setCountry($value['country'])
                    ->setPostalCode($value['postalCode']);

            $manager->persist($address);

            $this->addReference('address - ' . $key +1, $address);

        }


    }

    public function loadPost(ObjectManager $manager,)
    {



        $manager->flush();
    }
}
