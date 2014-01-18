<?php
namespace LDC\AccountBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepository extends DocumentRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $q = $this->createQueryBuilder()
            ->field('username')->equals((string) $username)
            ->getQuery();

        try
        {
            $user = $q->getSingleResult();
        }
        catch (NoResultException $e)
        {
            throw new UsernameNotFoundException(sprintf('Can\'t find Username "%s"', $username), null, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'LDC\AccountBundle\Document\User';
    }
}
