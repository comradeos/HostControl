<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Website\Website;
use App\Domain\Website\WebsiteRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class WebsiteRepository implements WebsiteRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Website $website): void
    {
        $entity = $this->em
            ->getRepository(WebsiteEntity::class)
            ->findOneBy(['uuid' => $website->getUuid()]);

        if ($entity === null) {
            $entity = new WebsiteEntity();
        }

        $entity->setUuid($website->getUuid());
        $entity->setDomainUuid($website->getDomainUuid());
        $entity->setRootPath($website->getRootPath());
        $entity->setPhpVersion($website->getPhpVersion());
        $entity->setDiskLimitMb($website->getDiskLimitMb());
        $entity->setCpuLimit($website->getCpuLimit());
        $entity->setCreatedAt($website->getCreatedAt());

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function findByUuid(string $uuid): ?Website
    {
        $entity = $this->em
            ->getRepository(WebsiteEntity::class)
            ->findOneBy(['uuid' => $uuid]);

        if ($entity === null) {
            return null;
        }

        return $this->mapToDomain($entity);
    }

    public function findAll(int $limit, int $offset): array
    {
        $entities = $this->em
            ->getRepository(WebsiteEntity::class)
            ->findBy([], null, $limit, $offset);

        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->mapToDomain($entity);
        }

        return $result;
    }

    public function countAll(): int
    {
        return $this->em
            ->getRepository(WebsiteEntity::class)
            ->count([]);
    }

    public function delete(Website $website): void
    {
        $entity = $this->em
            ->getRepository(WebsiteEntity::class)
            ->findOneBy(['uuid' => $website->getUuid()]);

        if ($entity === null) {
            return;
        }

        $this->em->remove($entity);
        $this->em->flush();
    }

    private function mapToDomain(WebsiteEntity $entity): Website
    {
        return new Website(
            $entity->getUuid(),
            $entity->getDomainUuid(),
            $entity->getRootPath(),
            $entity->getPhpVersion(),
            $entity->getDiskLimitMb(),
            $entity->getCpuLimit(),
            $entity->getCreatedAt()
        );
    }
}
