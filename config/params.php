<?php
declare(strict_types=1);

return [
    'routing' => [
        'uuid_v4' => '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}'
    ],
    'upload' => [
        'max_filesize' => env('UPLOAD_MAX_FILESIZE')
    ],
    'paths' => [
        'temp' => '/tmp'
    ]
];
