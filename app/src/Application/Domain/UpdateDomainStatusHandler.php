<?php

declare(strict_types=1);

namespace App\Application\Domain;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Domain\Domain\Domain;
use App\Domain\Domain\DomainRepositoryInterface;
use App\Domain\Domain\DomainStatus;
use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateDomainStatusHandler
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

    /**
     * @throws ValidationException
     */
    public function handle(UpdateDomainStatusCommand $command): void
    {
        ValidationHelper::validate($command, $this->validator);

        $domain = $this->repository->findByUuid($command->getUuid());

        if ($domain === null) {
            throw new InvalidArgumentException('Domain not found');
        }

        $updated = new Domain(
            uuid: $domain->getUuid(),
            name: $domain->getName(),
            accountUuid: $domain->getAccountUuid(),
            status: DomainStatus::from($command->getStatus())->value,
            createdAt: $domain->getCreatedAt()
        );

        $this->repository->save($updated);
    }
}
