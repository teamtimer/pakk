<?php

namespace App\Console\Commands;

use App\Generators\EntityImage;
use Cycle\ORM\Schema;
use Cycle\Schema\Renderer\OutputSchemaRenderer;
use Cycle\Schema\Renderer\PhpSchemaRenderer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TeamTimer\Pakk\App;

class MakeEntityCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('make:entity')
            ->setDescription('Create an entity from database schema')
            ->setHelp('This command allows you to create an entity from database schema')
            /** add arguments */
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the entity')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = App::$dbal->database()->table($input->getArgument('name'));
        $fileName = ucfirst($input->getArgument('name')) . '.php';

        $entitySkeleton = new EntityImage(namespace: 'App\Entities', entityName: $input->getArgument('name'), table: $table);

        file_put_contents(ABSPATH . 'src/Entities/' . $fileName , $entitySkeleton->getFile()->render());

        return Command::SUCCESS;
    }

    private function getColumnNames(array $columns){
        $columnNames = [];
        foreach($columns as $column){
            $columnNames[] = $column->getName();
        }
        return $columnNames;
    }

    private function getColumnsTypecasts(array $columns){
        $columnTypes = [];
        foreach($columns as $column){
            $columnTypes[] = $column->getType();
        }
        return $columnTypes;
    }
}