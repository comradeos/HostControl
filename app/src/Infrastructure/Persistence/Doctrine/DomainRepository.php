<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Domain\Domain;
use App\Domain\Domain\DomainRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DomainRepository implements DomainRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Domain $domain): void
    {
        $repository = $this->entityManager->getRepository(DomainEntity::class);

        $entity = $repository->findOneBy(['uuid' => $domain->getUuid()]);

        if ($entity === null) {
            $entity = new DomainEntity();
            $entity->setUuid($domain->getUuid());
            $entity->setCreatedAt($domain->getCreatedAt());
        }

        $entity->setName($domain->getName());
        $entity->setAccountUuid($domain->getAccountUuid());
        $entity->setStatus($domain->getStatus());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findByUuid(string $uuid): ?Domain
    {
        $repository = $this->entityManager->getRepository(DomainEntity::class);

        $entity = $repository->findOneBy(['uuid' => $uuid]);

        if ($entity === null) {
            return null;
        }

        return $this->mapToDomain($entity);
    }

    public function findAll(int $limit, int $offset): array
    {
        $repository = $this->entityManager->getRepository(DomainEntity::class);

        $entities = $repository->findBy([], null, $limit, $offset);

        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->mapToDomain($entity);
        }

        return $result;
    }

    public function count(): int
    {
        $repository = $this->entityManager->getRepository(DomainEntity::class);

        return $repository->count([]);
    }

    public function delete(string $uuid): void
    {
        $repository = $this->entityManager->getRepository(DomainEntity::class);

        $entity = $repository->findOneBy(['uuid' => $uuid]);

        if ($entity === null) {
            return;
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    private function mapToDomain(DomainEntity $entity): Domain
    {
        return new Domain(
            uuid: $entity->getUuid(),
            name: $entity->getName(),
            accountUuid: $entity->getAccountUuid(),
            status: $entity->getStatus(),
            createdAt: $entity->getCreatedAt()
        );
    }
}
