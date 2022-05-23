<?php

namespace App;

use App\Interfaces\OpenCloseFileInterface;

class OpenCloseCsvFile implements OpenCloseFileInterface
{
    /**
     * @return resource|false
     */
    public function openFile($filePath)
    {
        return fopen($filePath, "r");
    }

    public function closeFile($file): void
    {
        fclose($file);
    }
}