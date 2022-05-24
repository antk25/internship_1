<?php

namespace App;

class Row
{
    public function __construct(private readonly array $headers, private readonly array $values)
    {

    }

    public function createItem(): object
    {
        return (object) array_combine($this->headers, $this->values);
    }

}
