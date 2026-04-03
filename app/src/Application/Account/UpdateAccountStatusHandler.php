<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\Account\AccountRepositoryInterface;
use App\Domain\Account\AccountStatus;
use InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateAccountStatusHandler
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

    public function handle(UpdateAccountStatusCommand $command): void
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

        $uuid = $command->getUuid();
        $statusValue = $command->getStatus();

        $account = $this->repository->findByUuid($uuid);

        if ($account === null) {
            throw new InvalidArgumentException('Account not found');
        }

        $status = AccountStatus::tryFrom($statusValue);

        if ($status === null) {
            throw new InvalidArgumentException('Invalid status value');
        }

        $account->changeStatus($status);

        $this->repository->save($account);
    }
}
