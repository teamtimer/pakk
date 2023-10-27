<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TeamTimer\Pakk\App;

class MigrationsDownCommand extends Command
{

    protected function configure(): void
    {
        $this
            ->setName('migrations:down')
            ->setDescription('Migrate the database')
            ->setHelp('This command allows you to migrate the database down')
            /** add arguments */
            ->addArgument('count', InputArgument::OPTIONAL, 'The number of migrations to run', 1)
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = new \Cycle\Migrations\Config\MigrationConfig([
            'directory' => ABSPATH . 'src/Migrations',
            'table' => 'migrations',
            'namespace' => 'App\Migrations',
            'safe' => true
        ]);

        $migrator = new \Cycle\Migrations\Migrator($config, App::$dbal, new \Cycle\Migrations\FileRepository($config));
        $migrator->configure();

        $found = false;
//        $count = $this->option('one') ? 1 : PHP_INT_MAX;
        $count = $input->getArgument('count');


        while ($count > 0 && ($migration = $migrator->rollback())) {
            $found = true;
            $count--;

            $output->writeln(sprintf(
                "<info>Migration <comment>%s</comment> was successfully rolled back.</info>\n",
                $migration->getState()->getName()
            ));
        }

        if (!$found) {
            $output->writeln('<fg=red>No executed migrations were found.</fg=red>');
        }

        return Command::SUCCESS;
    }
}