<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\CsvReader;

$test = new CsvReader();
//$data = [];
foreach ($test->getRowsChunks("/var/www/internship_1/report.csv") as $row) {
    var_dump($row);
}
//$data = (object) $test->getHeaders("/var/www/internship_1/report.csv");
//$data = $test->getRow2("/var/www/internship_1/report.csv");
//var_dump($data);
