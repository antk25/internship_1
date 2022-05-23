<?php

namespace App;

use Generator;

class CsvReader
{
    private const SEPARATOR = ";";
    private const DEFAULT_CHUNK_SIZE = 3;
    private OpenCloseCsvFile $openCloseCsvFile;

    public function __construct($openCloseCsvFile = new OpenCloseCsvFile())
    {
        $this->openCloseCsvFile = $openCloseCsvFile;
    }

    public function getRows($fileReportCsv): Generator
    {
        $handle = $this->openCloseCsvFile->openFile($fileReportCsv);
        $headers = self::getHeaders($fileReportCsv);

        fgets($handle);

        while (!feof($handle)) {
            $values = fgetcsv($handle, separator: self::SEPARATOR);
            yield self::createRow($headers, $values);
        }

        $this->openCloseCsvFile->closeFile($handle);
    }

    public function getRowsChunks($fileReportCsv, $chunkSize = self::DEFAULT_CHUNK_SIZE): Generator
    {
        $rows = [];

        foreach (self::getRows($fileReportCsv) as $row)
        {
            $rows[] = $row;

            if (count($rows) >= $chunkSize) {
                yield $rows;
                $rows = [];
            }
        }

        yield $rows;

    }

    private function getHeaders($fileReportCsv): bool|array
    {
        $handle = $this->openCloseCsvFile->openFile($fileReportCsv);

        return fgetcsv($handle, separator: self::SEPARATOR);
    }

    private function createRow(array|bool $headers, array|bool $values): object
    {
        $row = new Row($headers, $values);

        return $row->createCell();
    }
}