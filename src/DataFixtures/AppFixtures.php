<?php

namespace App\DataFixtures;

use App\Entity\Status;
use App\Entity\Categories;
use App\Entity\SuggestedTasks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\AbstractUnicodeString;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        

        $manager->flush();
    }

    
}
