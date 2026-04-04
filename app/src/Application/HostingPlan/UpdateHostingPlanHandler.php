<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Domain\HostingPlan\HostingPlan;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateHostingPlanHandler
{
    private HostingPlanRepositoryInterface $repository;

    private ValidatorInterface $validator;

    public function __construct(
        HostingPlanRepositoryInterface $repository,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    public function handle(UpdateHostingPlanCommand $command): void
    {
        ValidationHelper::validate($command, $this->validator);

        $uuid = $command->getUuid();

        $plan = $this->repository->findByUuid($uuid);

        if ($plan === null) {
            throw new InvalidArgumentException('Hosting plan not found');
        }

        $updated = new HostingPlan(
            uuid: $plan->getUuid(),
            name: $command->getName(),
            diskSpaceMb: $command->getDiskSpaceMb(),
            bandwidthMb: $command->getBandwidthMb(),
            price: $command->getPrice(),
            createdAt: $plan->getCreatedAt()
        );

        $this->repository->save($updated);
    }
}
