<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Domain\HostingPlan\HostingPlan;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use DateTimeImmutable;
use InvalidArgumentException;
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

    public function handle(CreateHostingPlanCommand $command): HostingPlan
    {
        $errors = $this->validator->validate($command);

        if (count($errors) > 0) {
            $result = [];

            foreach ($errors as $error) {
                $field = $error->getPropertyPath();

                $result[$field][] = $error->getMessage();
            }

            throw new InvalidArgumentException(
                json_encode($result)
            );
        }

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

        return $plan;
    }
}
