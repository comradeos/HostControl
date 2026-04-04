<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Application\HostingPlan\DTO\HostingPlanResponse;
use App\Domain\HostingPlan\HostingPlan;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateHostingPlanHandler
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
    public function handle(CreateHostingPlanCommand $command): HostingPlanResponse
    {
        ValidationHelper::validate($command, $this->validator);

        $uuid = Uuid::uuid7()->toString();

        $plan = new HostingPlan(
            uuid: $uuid,
            name: $command->getName(),
            diskSpaceMb: $command->getDiskSpaceMb(),
            bandwidthMb: $command->getBandwidthMb(),
            price: $command->getPrice(),
            createdAt: new DateTimeImmutable()
        );

        $this->repository->save($plan);

        return new HostingPlanResponse($plan);
    }
}
