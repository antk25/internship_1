<?php

namespace App;

use App\Interfaces\OpenCloseFileInterface;

class CsvReaderForReport
{
    private const SEPARATOR = ';';
    private const DEFAULT_CHUNK_SIZE = 3;

    private OpenCloseFileInterface $openCloseFile;

    public function __construct(OpenCloseFileInterface $openCloseFile)
    {
        $this->openCloseFile = $openCloseFile;
    }

    public function getRows($fileReportCsv): \Generator
    {
        $handle = $this->openCloseFile->openFile($fileReportCsv);
        $headers = self::getHeaders($fileReportCsv);

        fgets($handle);

        while (($values = fgetcsv($handle, separator: self::SEPARATOR)) !== false) {
            yield self::createItemFromRow($headers, $values);
        }

        $this->openCloseFile->closeFile($handle);
    }

    public function getRowsChunks($fileReportCsv, $chunkSize = self::DEFAULT_CHUNK_SIZE): \Generator
    {
        $chunkSize = self::correctChunkSize($chunkSize);

        $rows = [];

        foreach (self::getRows($fileReportCsv) as $row) {
            $rows[] = $row;

            if (count($rows) >= $chunkSize) {
                yield $rows;
                $rows = [];
            }
        }

        yield $rows;
    }

    private static function correctChunkSize(int $chunkSize): int
    {
       if ($chunkSize <= 0) {
           $chunkSize = self::DEFAULT_CHUNK_SIZE;
       }

       return $chunkSize;
    }

    private function getHeaders($fileReportCsv): array
    {
        $handle = $this->openCloseFile->openFile($fileReportCsv);

        $headers = fgetcsv($handle, separator: self::SEPARATOR);

        if ($headers === false) {
            $headers = [];
        }

        return $headers;
    }

    private function createItemFromRow(array $headers, array $values): object
    {
        $row = new Row($headers, $values);

        return $row->createItem();
    }
}
