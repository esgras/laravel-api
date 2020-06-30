<?php
declare(strict_types=1);

namespace App\Utils;

interface ValidateEntityInterface
{
    public function toArray(): array;

    public function rules(): array;

    public function messages(): array;
}
