<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Services\Dto\RetailerAssignDto;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    final public function authorize(): bool
    {
        return true;
    }

    public function getBulkArrayInput(): array
    {
        return array_filter($this->input(), fn($input) => is_array($input));
    }
}
