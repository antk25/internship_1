<?php

namespace App\Interfaces;

interface OpenCloseFileInterface
{
    public function openFile(string $filePath): mixed;

    public function closeFile($file): void;
}
