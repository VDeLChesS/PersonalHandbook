<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Status;
use App\Entity\Categories;
use App\Entity\SuggestedTasks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    private readonly SluggerInterface $slugger;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger) 
    {
        $this->passwordHasher = $passwordHasher;
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUser($manager);
        $this->loadStatus($manager);
        $this->loadCategories($manager);
        
    
    }

    public function loadUser(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFname('Sara');
        $user->setLname('Hirsch');
        $user->setDob(new \DateTime('1997-02-11'));
        $user->setGender('Female');
        $user->setPhone('1234433213');
        $user->setEmail('sara.hirsch@mail.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'sarahirsch123'));

        $manager->persist($user);
        $manager->flush();
    }

    public function loadStatus(ObjectManager $manager): void
    {
        foreach ($this->getStatus() as $status) {
            $status = (new Status())->setName($status);
            $manager->persist($status);
        }

        $manager->flush();
    }

    public function loadCategories(ObjectManager $manager): void
    {
        foreach ($this->getCategories() as $category) {
            $category = (new Categories())->setName($category);
            $manager->persist($category);
        }

        $manager->flush();
    }
/*
    public function loadSuggestedTasks(ObjectManager $manager): void
    {
        $titles = $this->getSuggestedTaskTitle();
        $descriptions = $this->getSuggestedTasksDescriptions();
        $pictures = $this->getSuggestedTasksPictures();
        $suggestedTask;

        for ($i = 0; $i < count($titles); $i++) {
            $suggestedTask = (new SuggestedTasks())
                ->setTitle($titles[$i])
                ->setDescription($descriptions[$i])
                ->setPicture($pictures[$i]);

            $manager->persist($suggestedTask);
        }

        $manager->flush();
    }
*/
    public function getStatus(): array
    {
        return [
            'Pending',
            'In Progress',
            'Completed',
            'On Hold',
            'Cancelled'
        ];
    }

    public function getCategories(): array
    {
        return [
            'Personal',
            'Work',
            'School',
            'Health',
            'Finance',
            'Family',
            'Friends',
            'Travel',
            'Fitness',
            'Food',
            'Hobbies',
            'Entertainment',
            'Sports',
            'Technology',
            'Shopping',
            'Others'
        ];
    }

    public function getSuggestedTaskTitle(): array
    {
        return [
            'Go for a walk',
            'Read a book',
            'Watch a movie',
            'Cook a meal',
            'Call a friend',
            'Write a blog post',
            'Learn a new language',
            'Learn a new skill',
            'Start a new project',
            'Go to the gym',
            'Go for a run',
            'Go for a swim',
            'Go for a bike ride',
            'Go for a hike',
            'Go for a drive',
            'Go for a picnic',
            'Go for a camping',
            'Go for a fishing',
            'Go for a hunting',
            'Go for a skiing',
            'Go for a snowboarding',
            'Go for a skating',
            'Go for a surfing',
            'Go for a sailing',
            'Go for a kayaking',
            'Go for a canoeing',
            'Go for a rafting',
            'Go for a bungee jumping',
            'Go for a skydiving',
            'Go for a paragliding',
            'Go for a hang gliding',
            'Go for a scuba diving',
            'Go for a snorkeling',
            'Go for a rock climbing',
            'Go for a mountain climbing',
            'Go for a caving',
            'Go for a canyoning',
            'Go for a zip lining',
            'Go for a hot air ballooning',
            'Go for a horseback'
        ];
    }

    public function getSuggestedTasksDescriptions(): array
    {
        return [
            'Go for a walk in the park',
            'Read a book in the library',
            'Watch a movie in the cinema',
            'Cook a meal in the kitchen',
            'Write a blog post on the computer',
            'Learn a new language on the internet',
            'Learn a new skill on the internet',
            'Start a new project on the internet',
            'Go to the gym for a workout',
            'Go for a run in the park',
            'Go for a swim in the pool',
            'Go for a bike ride in the park',
            'Go for a hike in the mountains',
            'Go for a drive in the countryside',
            'Go for a picnic in the park',
            'Go for a camping in the forest',
            'Go for a fishing in the river',
            'Go for a hunting in the forest',
            'Go for a skiing in the mountains',
            'Go for a snowboarding in the mountains',
            'Go for a skating in the park',
            'Go for a surfing in the ocean',
            'Go for a sailing in the ocean',
            'Go for a kayaking in the river',
            'Go for a canoeing in the river',
            'Go for a rafting in the river',
            'Go for a bungee jumping in the park',
            'Go for a skydiving in the park',
            'Go for a paragliding in the park',
            'Go for a hang gliding in the park',
            'Go for a scuba diving in the ocean',
            'Go for a snorkeling in the ocean',
            'Go for a rock climbing in the mountains',
            'Go for a mountain climbing in the mountains',
            'Go for a caving in the mountains',
            'Go for a canyoning in the mountains',
            'Go for a zip lining in the mountains',
            'Go for a hot air ballooning in the mountains',
            'Go for a horseback in the mountains'
        ];
    }

    public function getSuggestedTasksPictures(): array {
        return [
            'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcT1FaMwTxsxuULmA6yfKOdjrkaHhUJMfZoXdMDDVhBAU9DLssL6',
            'https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRQr-xP_vScNrd9CayqvsrdP2CMXzCf_saXRyHU8yYcH8S7pYRM',
            'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcSA-k4DO36Z8htYLZ4kiZdba_uGgUwSkclGm1SiFUa-I-g1D-QO',
            'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ1',
            'https://www.allrecipes.com/thmb/l8pBk66tjSKHNnj_opc78m0_WAA=/1500x2000/filters:no_upscale():max_bytes(150000):strip_icc()/Chopping-vegetables-2000-def12c1f5bc147d4a60ee92825b46aab.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSe4X7UhIBrKTI8Zmabqnij6QZlqzu517RlLA&s',
            'https://blogassets.leverageedu.com/blog/wp-content/uploads/2020/12/03195139/how-to-learn-new-languages-01.jpg',
            'https://miro.medium.com/v2/resize:fit:1400/1*ueMgiSSijRGcayU3CiP19Q.png'
        ];

    }
}
