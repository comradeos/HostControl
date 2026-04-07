<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Account\Account;
use App\Domain\Account\AccountRepositoryInterface;
use App\Domain\Account\AccountRole;
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
            $entity->setPassword($account->getPassword());
            $entity->setFullName($account->getFullName());
            $entity->setRole($account->getRole());
            $entity->setCreatedAt($account->getCreatedAt());
        }

        $entity->setStatus($account->getStatus());
        $entity->setPassword($account->getPassword());
        $entity->setRole($account->getRole());

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

    public function findByEmail(string $email): ?Account
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entity = $repository->findOneBy(['email' => $email]);

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

    public function findByStatus(string $status, int $limit, int $offset): array
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        $entities = $repository->findBy(
            ['status' => $status],
            null,
            $limit,
            $offset
        );

        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->mapToDomain($entity);
        }

        return $result;
    }

    public function countByStatus(string $status): int
    {
        $repository = $this->entityManager->getRepository(AccountEntity::class);

        return $repository->count(['status' => $status]);
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
        $password = $entity->getPassword();
        $fullName = $entity->getFullName();
        $role = $entity->getRole();
        $status = $entity->getStatus();
        $createdAt = $entity->getCreatedAt();

        $account = new Account(
            uuid: $uuid,
            email: $email,
            password: $password,
            fullName: $fullName,
            role: AccountRole::from($role->value ?? $role),
            status: $status,
            createdAt: $createdAt
        );

        return $account;
    }
}
