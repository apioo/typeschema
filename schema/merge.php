<?php

$baseDir = __DIR__ . '/output';
$files = scandir($baseDir);
$types = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'html') {
        continue;
    }

    $types[] = file_get_contents($baseDir . '/' . $file);
}

file_put_contents(__DIR__ . '/schema.htm', implode("\n\n", $types));
