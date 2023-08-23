<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserData;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<UserData>
 *
 * @method UserData|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserData|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserData[]    findAll()
 * @method UserData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDataRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserData::class);
    }

    public function updateUserData(UserData $userData)
    {
        if (!$userData instanceof UserData) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $userData::class));
        }

        $this->getEntityManager()->persist($userData);
        $this->getEntityManager()->flush();
    }

}
