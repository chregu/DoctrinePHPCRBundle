<?php

namespace Symfony\Bundle\DoctrinePHPCRBundle\Command;

use Doctrine\ODM\PHPCR\Tools\Console\Command\RegisterSystemNodeTypesCommand as BaseRegisterSystemNodeTypesCommand;
use Doctrine\ODM\PHPCR\Tools\Console\Helper\DocumentManagerHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Wrapper to use RegisterSystemNodeTypeCommand with Symfony's app/console
 *
 * @see Doctrine/ODM/PHPCR/Tools/Console/Command/RegisterSystemNodeTypesCommand
 *
 * TODO: a option for different document manager once this is implemented
 */
class RegisterSystemNodeTypesCommand extends BaseRegisterSystemNodeTypesCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('doctrine:phpcr:register-system-node-types');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getApplication()->getKernel()->getContainer();
        $dmServiceName = 'doctrine.phpcr_odm.document_manager';
        if (!$container->has($dmServiceName)) {
            throw new \InvalidArgumentException('Could not find Doctrine ODM PHPCR DocumentManager');
        }

        $dm = $container->get($dmServiceName);
        $helperSet = $this->getApplication()->getHelperSet();
        $helperSet->set(new DocumentManagerHelper($dm), 'dm');

        parent::execute($input, $output);
    }
}
