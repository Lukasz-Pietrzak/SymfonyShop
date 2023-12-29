<?php 
// src/Command/GenerateUuidCommand.php

namespace App\Command;

use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateUuidCommand extends Command
{
    protected static $defaultName = 'app:generate-uuid';

    protected function configure()
    {
        $this->setDescription('Generate UUID v7');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = Uuid::uuid7(); // Zmiana na uuidV7 zamiast uuid7
        $output->writeln('Generated UUID v7: ' . $uuid->toString());

        return Command::SUCCESS;
    }
}
