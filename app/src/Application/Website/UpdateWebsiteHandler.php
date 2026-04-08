<?php

declare(strict_types=1);

namespace App\Application\Website;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Application\Website\DTO\WebsiteResponse;
use App\Domain\Website\Website;
use App\Domain\Website\WebsiteRepositoryInterface;
use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateWebsiteHandler
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
    public function handle(UpdateWebsiteCommand $command): WebsiteResponse
    {
        ValidationHelper::validate($command, $this->validator);

        $existing = $this->repository->findByUuid($command->getUuid());

        if ($existing === null) {
            throw new InvalidArgumentException('Website not found');
        }

        $updated = new Website(
            $existing->getUuid(),
            $command->getDomainUuid(),
            $command->getRootPath(),
            $command->getPhpVersion(),
            $command->getDiskLimitMb(),
            $command->getCpuLimit(),
            $existing->getCreatedAt()
        );

        $this->repository->save($updated);

        return new WebsiteResponse($updated);
    }
}
