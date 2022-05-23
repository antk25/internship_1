<?php

namespace App;

class Row
{
    public function __construct(private readonly array|bool $headers, private readonly array|bool $values)
    {}

    public function createCell(): object
    {
        return (object) array_combine($this->headers, $this->values);
    }

}