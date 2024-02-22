<?php

declare(strict_types=1);

namespace App\Handler;

class Calculate
{
    private $result;

    public function additionProvider(): void
    {
        $this->result = 3 + 5;
    }

    public function getResult(): int
    {
        return $this->result;
    }
}
