<?php

namespace App\DataFixtures;

use App\Entity\Organisation;
use App\Entity\OrganisationRelation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('henk@example.nl');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'test1234'));
        $manager->persist($user);

        $organisationABC = new Organisation();
        $organisationABC->setName('Organisatie ABC');
        $organisationABC->setLocation('Amsterdam');
        $manager->persist($organisationABC);

        $organisationRelationABC = new OrganisationRelation();
        $organisationRelationABC->setOrganisation($organisationABC);
        $organisationRelationABC->setUser($user);
        $manager->persist($organisationRelationABC);

        $organisationXYZ = new Organisation();
        $organisationXYZ->setName('Organisatie XYZ');
        $organisationXYZ->setLocation('Rotterdam');
        $manager->persist($organisationXYZ);

        $organisationRelationXYZ = new OrganisationRelation();
        $organisationRelationXYZ->setOrganisation($organisationXYZ);
        $organisationRelationXYZ->setUser($user);
        $manager->persist($organisationRelationXYZ);

        $manager->flush();
    }
}
