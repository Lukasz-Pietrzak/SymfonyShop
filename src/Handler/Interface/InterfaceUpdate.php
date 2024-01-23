<?php

declare(strict_types=1);

namespace App\Handler\Interface;

interface InterfaceUpdate
{
    /**
     * @template TEntity
     * @template TDTO
     * @param TEntity $entity
     * @param TDTO $dto
     */
    public function update(object $entity, object $dto): void;
}
