<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

while (true) {
    $ch = curl_init('0.0.0.0:9254');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $explode = explode("\n", $response);

        foreach ($explode as $string) {
            if (str_starts_with($string, 'rr_jobs_workers_working')/* || str_starts_with($string, 'rr_jobs_workers_ready')*/) {
                echo $string;
            }
        }
    }

    sleep(1);
}
