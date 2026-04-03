<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Account\Account;
use App\Domain\Account\AccountRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class AccountRepository implements AccountRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Account $account): void
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entity = $repository->findOneBy(['uuid' => $account->getUuid()]);

        if ($entity === null) {
            $entity = new AccountEntity();
            $entity->setUuid($account->getUuid());
            $entity->setEmail($account->getEmail());
            $entity->setFullName($account->getFullName());
            $entity->setCreatedAt($account->getCreatedAt());
        }

        $entity->setStatus($account->getStatus());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function findById(int $id): ?Account
    {
        $entity = $this->entityManager->find(AccountEntity::class, $id);

        if ($entity === null) {
            return null;
        }

        return $this->mapToDomain($entity);
    }

    public function findByUuid(string $uuid): ?Account
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entity = $repository->findOneBy(['uuid' => $uuid]);

        if ($entity === null) {
            return null;
        }

        return $this->mapToDomain($entity);
    }

    public function findAll(int $limit, int $offset): array
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entities = $repository->findBy([], null, $limit, $offset);

        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->mapToDomain($entity);
        }

        return $result;
    }

    public function countAll(): int
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        return $repository->count();
    }

    public function existsByEmail(string $email): bool
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entity = $repository->findOneBy(['email' => $email]);

        if ($entity === null) {
            return false;
        }

        return true;
    }

    private function mapToDomain(AccountEntity $entity): Account
    {
        $uuid = $entity->getUuid();
        $email = $entity->getEmail();
        $fullName = $entity->getFullName();
        $status = $entity->getStatus();
        $createdAt = $entity->getCreatedAt();

        $account = new Account(
            uuid: $uuid,
            email: $email,
            fullName: $fullName,
            status: $status,
            createdAt: $createdAt
        );

        return $account;
    }
}
