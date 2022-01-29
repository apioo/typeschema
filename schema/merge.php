<?php

$files = scandir(__DIR__);
$types = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'html') {
        continue;
    }

    $types[] = file_get_contents(__DIR__ . '/' . $file);
}

file_put_contents(__DIR__ . '/schema.htm', implode("\n\n", $types));
