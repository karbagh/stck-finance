<?php

namespace App\Dto;

abstract class Dto
{
    public abstract function toArray(): array;
}
