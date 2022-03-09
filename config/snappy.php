<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => '/usr/local/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => ['viewport-size' => '1280x1024', 'dpi' => 72, 'enable-local-file-access' => true],
        'env' => [],
    ],
    'image' => [
        'enabled' => true,
        'binary' => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],
];
