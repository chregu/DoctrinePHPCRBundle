<?php

namespace Symfony\Bundle\DoctrinePHPCRBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Jackalope\Transport\Doctrine\RepositorySchema;

class CreateWorkSpaceCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:phpcr:init:dbal')
            ->addArgument('name', InputArgument::REQUIRED, 'A workspace name')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $transport = $this->container->get('jackalope.transport');

        $name = $input->getArgument('name');
        $transport->createWorkspace($name);

        $output->writeln("The workspace '$name' created.");
    }
}
