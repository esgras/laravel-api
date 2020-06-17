<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function upload(): Response
    {
        return new Response('upload');
    }
}
