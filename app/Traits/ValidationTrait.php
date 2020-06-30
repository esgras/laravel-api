<?php
declare(strict_types=1);

namespace App\Traits;

use App\Utils\ValidateEntityInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidationTrait
{
    public function validateEntity(ValidateEntityInterface $entity): void
    {
        $validator = Validator::make($entity->toArray(), $entity->rules(), $entity->messages() ?? []);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
