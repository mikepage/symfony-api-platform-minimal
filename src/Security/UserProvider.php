<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (!$this->userRepository instanceof UserLoaderInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'You must either make the "%s" entity Doctrine Repository ("%s") implement "Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface" or set the "property" option in the corresponding entity provider configuration.',
                    User::class,
                    get_debug_type($this->userRepository)
                )
            );
        }

        $user = $this->userRepository->loadUserByIdentifier($identifier);

        if (null === $user) {
            $e = new UserNotFoundException(sprintf('User "%s" not found.', $identifier));
            $e->setUserIdentifier($identifier);

            throw $e;
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_debug_type($user)));
        }

        if (!$id = $this->getClassMetadata()->getIdentifierValues($user)) {
            throw new \InvalidArgumentException(
                'You cannot refresh a user from the UserProvider that does not contain an identifier. The user object has to be serialized with its own identifier mapped by Doctrine.'
            );
        }

        $refreshedUser = $this->userRepository->find($id);

        if (null === $refreshedUser) {
            $e = new UserNotFoundException('User with id ' . json_encode($id, JSON_THROW_ON_ERROR) . ' not found.');
            $e->setUserIdentifier(json_encode($id, JSON_THROW_ON_ERROR));

            throw $e;
        }

        return $refreshedUser;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    protected function getClassMetadata(): ClassMetadata
    {
        return $this->entityManager->getClassMetadata(User::class);
    }
}