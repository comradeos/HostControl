<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\HostingPlan\HostingPlan;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class HostingPlanRepository implements HostingPlanRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(HostingPlan $plan): void
    {
        $repository = $this->entityManager->getRepository(HostingPlanEntity::class);

        $entity = $repository->findOneBy(['uuid' => $plan->getUuid()]);

        if ($entity === null) {
            $entity = new HostingPlanEntity();
            $entity->setUuid($plan->getUuid());
            $entity->setCreatedAt($plan->getCreatedAt());
        }

        $entity->setName($plan->getName());
        $entity->setDiskSpaceMb($plan->getDiskSpaceMb());
        $entity->setBandwidthMb($plan->getBandwidthMb());
        $entity->setPrice($plan->getPrice());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findByUuid(string $uuid): ?HostingPlan
    {
        $repository = $this->entityManager->getRepository(HostingPlanEntity::class);

        $entity = $repository->findOneBy(['uuid' => $uuid]);

        if ($entity === null) {
            return null;
        }

        return $this->mapToDomain($entity);
    }

    public function findAll(int $limit, int $offset): array
    {
        $repository = $this->entityManager->getRepository(HostingPlanEntity::class);

        $entities = $repository->findBy([], null, $limit, $offset);

        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->mapToDomain($entity);
        }

        return $result;
    }

    public function countAll(): int
    {
        $repository = $this->entityManager->getRepository(HostingPlanEntity::class);

        return $repository->count();
    }

    private function mapToDomain(HostingPlanEntity $entity): HostingPlan
    {
        return new HostingPlan(
            uuid: $entity->getUuid(),
            name: $entity->getName(),
            diskSpaceMb: $entity->getDiskSpaceMb(),
            bandwidthMb: $entity->getBandwidthMb(),
            price: $entity->getPrice(),
            createdAt: $entity->getCreatedAt()
        );
    }
}
