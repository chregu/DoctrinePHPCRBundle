<?php

namespace Symfony\Bundle\DoctrinePHPCRBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Jackalope\Transport\Doctrine\RepositorySchema;

class InitDoctrineDbalCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:phpcr:init:dbal')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $transport = $this->container->get('jackalope.transport');
        $connection = $transport->getConnection();

        $schema = RepositorySchema::create();
        foreach ($schema->toSql($connection->getDatabasePlatform()) as $sql) {
            $connection->exec($sql);
        }

        $transport->createWorkspace('default');

        $output->writeln("Jackalope Doctrine DBAL tables have been initialized successfully and 'default' workspace created.");
    }
}
