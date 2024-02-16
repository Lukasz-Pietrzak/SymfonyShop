<?php

declare(strict_types=1);

use App\Provider\IngredientProvider;
use App\Repository\IngredientQueryRepository;
use PHPUnit\Framework\TestCase;

final class IngredientProviderTest extends TestCase
{
    public function testProviderByName(): void
    {
        $mockProvider = $this->createMock(IngredientProvider::class);
        
        $mockProvider->method('loadIngredientsByName')->willReturn(['szynka']);

        $ingredients = $mockProvider->loadIngredientsByName('szynka');

        $this->assertContains('szynka', $ingredients);
    }
}


