<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

while (true) {
    $ch = curl_init('php:9254');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $explode = explode("\n", $response);

        foreach ($explode as $string) {
            if (str_starts_with(
                $string,
                'rr_jobs_workers_working',
            )/* || str_starts_with($string, 'rr_jobs_workers_ready')*/) {
                var_dump($string);
            }
        }
    } else {
        var_dump(time() . " RESPONSE FAILED");
    }

    usleep(500000);
}
