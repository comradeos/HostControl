<?php

declare(strict_types=1);

namespace App\Application\Website;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Application\Website\DTO\WebsiteResponse;
use App\Domain\Website\Website;
use App\Domain\Website\WebsiteRepositoryInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateWebsiteHandler
{
    private WebsiteRepositoryInterface $repository;

    private ValidatorInterface $validator;

    public function __construct(
        WebsiteRepositoryInterface $repository,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    public function handle(CreateWebsiteCommand $command): WebsiteResponse
    {
        ValidationHelper::validate($command, $this->validator);

        $website = new Website(
            Uuid::uuid7()->toString(),
            $command->getDomainUuid(),
            $command->getRootPath(),
            $command->getPhpVersion(),
            $command->getDiskLimitMb(),
            $command->getCpuLimit(),
            new DateTimeImmutable()
        );

        $this->repository->save($website);

        return new WebsiteResponse($website);
    }
}
