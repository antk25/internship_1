<?php

namespace App\Interfaces;

interface OpenCloseFileInterface
{
    public function openFile(string $filePath);

    public function closeFile($file): void;
}