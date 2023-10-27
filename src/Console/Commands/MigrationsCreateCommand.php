<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TeamTimer\Pakk\App;

class MigrationsCreateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('migrations:create')
            ->setDescription('Create a database migration')
            ->setHelp('This command allows you to create a database migration')
            /** add arguments */
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = new \Cycle\Migrations\Config\MigrationConfig([
            'directory' => ABSPATH . 'src/Migrations',
            'table' => 'migrations',
            'safe' => true,
            'namespace' => 'App\Migrations',
        ]);

        $migrator = new \Cycle\Migrations\Migrator($config, App::$dbal, new \Cycle\Migrations\FileRepository($config));
        $migrator->configure();

        $migrationSkeleton = new \Cycle\Schema\Generator\Migrations\MigrationImage($config, 'default');

        $migrationFile = $migrator->getRepository()->registerMigration(
            $input->getArgument('name'),
            $migrationSkeleton->getClass(),
            $migrationSkeleton->getFile()->render()
        );

        $output->writeln(sprintf('Created migration <info>%s</info>', $migrationFile));

        return Command::SUCCESS;
    }
}