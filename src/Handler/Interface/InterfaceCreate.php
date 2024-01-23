<?php

declare(strict_types=1);

namespace App\Handler\Interface;

interface InterfaceCreate
{
    /**
     * @template TDTO
     * @param DTO $dto
     */
    public function create(object $dto): void;
}
