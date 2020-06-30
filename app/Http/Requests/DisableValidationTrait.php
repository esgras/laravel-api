<?php
declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Disable framework validation to force validate from code when needed
 */
trait DisableValidationTrait
{
    public function validateResolved(): void
    {
    }
}
