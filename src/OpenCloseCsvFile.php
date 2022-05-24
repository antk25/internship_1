<?php

namespace App;

use App\Interfaces\OpenCloseFileInterface;

class OpenCloseCsvFile implements OpenCloseFileInterface
{
    /**
     * @return resource
     */
    public function openFile(string $filePath): mixed
    {
        return fopen($filePath, 'r');
    }

    public function closeFile($file): void
    {
        fclose($file);
    }
}
