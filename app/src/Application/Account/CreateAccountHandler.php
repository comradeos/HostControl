<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Application\Account\DTO\AccountResponse;
use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Domain\Account\Account;
use App\Domain\Account\AccountRepositoryInterface;
use App\Domain\Account\AccountStatus;
use DateTimeImmutable;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAccountHandler
{
    private AccountRepositoryInterface $repository;

    private ValidatorInterface $validator;

    public function __construct(
        AccountRepositoryInterface $repository,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     */
    public function handle(CreateAccountCommand $command): AccountResponse
    {
        ValidationHelper::validate($command, $this->validator);

        $email = $command->getEmail();

        $exists = $this->repository->existsByEmail($email);

        if ($exists === true) {
            throw new InvalidArgumentException('Account with this email already exists');
        }

        $uuid = $this->generateUuid();
        $fullName = $command->getFullName();
        $status = AccountStatus::ACTIVE;
        $createdAt = new DateTimeImmutable();

        $account = new Account(
            uuid: $uuid,
            email: $email,
            fullName: $fullName,
            status: $status,
            createdAt: $createdAt
        );

        $this->repository->save($account);

        return new AccountResponse($account);
    }

    private function generateUuid(): string
    {
        return Uuid::uuid7()->toString();
    }
}
