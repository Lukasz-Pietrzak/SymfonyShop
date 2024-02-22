<?php

use App\Handler\Calculate;
use PHPUnit\Framework\TestCase;

final class CalculateTest extends TestCase
{
    public function testAdditionProvider(): void
    {
        $calculate = new Calculate();
        $calculate->additionProvider();
        
        $this->assertEquals($calculate->getResult(), 8);
    }
}
