<?php

const MAX_TRY = 4;
const WAIT = 30;

$domain = getenv('APP_DOMAIN');
$email = getenv('APP_EMAIL');

echo 'Try to obtain SSL cert for ' . $domain . "\n";

$count = 1;
$success = false;
while (!empty($domain) && $count <= MAX_TRY) {
    sleep(WAIT * $count);

    exec('certbot --apache -d ' . escapeshellarg($domain) . ' --agree-tos -m ' . escapeshellarg($email), $output, $exitCode);
    if ($exitCode === 0) {
        echo 'Obtained SSL cert for ' . $domain . "\n";
        break;
    } else {
        echo 'Could not obtain cert for domain ' . $domain . "\n";
        echo implode("\n", $output) . "\n";
    }

    $count++;
}

// remove file
echo 'Remove obtain SSL cert script' . "\n";

unlink(__FILE__);
exit(0);
