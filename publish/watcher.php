<?php

return [
    'start' => 'php bin/hyperf.php start',
    'driver' => 'fswatch',
    'watch' => [
        'dir' => ['app', 'config'],
        'files' => ['.env'],
    ],
];
