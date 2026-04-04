<?php

declare(strict_types=1);

namespace App\Application\Common;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationHelper
{
    /**
     * @throws ValidationException
     */
    public static function validate(object $command, ValidatorInterface $validator): void
    {
        $errors = $validator->validate($command);

        if (count($errors) > 0) {
            $result = [];

            foreach ($errors as $error) {
                $field = $error->getPropertyPath();
                $result[$field][] = $error->getMessage();
            }

            throw new ValidationException($result);
        }
    }
}
