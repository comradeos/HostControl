<?php

declare(strict_types=1);

namespace App\Application\Domain;

use App\Application\Common\ValidationHelper;
use App\Application\Domain\DTO\DomainResponse;
use App\Domain\Domain\Domain;
use App\Domain\Domain\DomainRepositoryInterface;
use App\Domain\Domain\DomainStatus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateDomainHandler
{
    private DomainRepositoryInterface $repository;

    private ValidatorInterface $validator;

    public function __construct(
        DomainRepositoryInterface $repository,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function handle(CreateDomainCommand $command): DomainResponse
    {
        ValidationHelper::validate($command, $this->validator);

        $domain = new Domain(
            uuid: Uuid::uuid7()->toString(),
            name: $command->getName(),
            accountUuid: $command->getAccountUuid(),
            status: DomainStatus::ACTIVE->value,
            createdAt: new \DateTimeImmutable()
        );

        $this->repository->save($domain);

        return new DomainResponse($domain);
    }
}
