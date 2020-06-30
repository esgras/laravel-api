<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EpackageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uploadFileMaxSize = config('params.upload.max_filesize');

        return [
            'archive' => "file|mimetypes:application/zip|max:{$uploadFileMaxSize}|required"
        ];
    }
}
