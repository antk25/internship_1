<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\CsvReaderForReport;

$csvReaderForReport = new CsvReaderForReport();

foreach ($csvReaderForReport->getRows("/var/www/internship_1/report.csv", 2) as $row) {
    var_dump($row);
}
