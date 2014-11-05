<?php

namespace MTLA\FeaturedCarBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SyncDataCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mtla:sync')
            ->setDescription('Synchroniser des données')
            ->addArgument(
                'task',
                InputArgument::OPTIONAL,
                'Quelles tâche voulez-vous synchroniser?'
            )
            ->addOption(
               'limit',
               null,
               InputOption::VALUE_OPTIONAL,
               'Limite d\'élément à traiter par tâche'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $task = $input->getArgument('task');
	$task = $task ?: '*';

        if ($input->getOption('limit')) {
            if (!is_numeric($input->getOption('limit'))) {
                throw new \InvalidArgumentException('Limit must be numeric');
            }
            
            $output->writeln(sprintf('[limit: %s]', $input->getOption('limit')));
        }

	switch ($task) {
		case '*':
			$this->executeAll($input, $output);
			break;

		case 'database':
			$this->executeDatabase($input, $output);
			break;

		case 'files':
			$this->executeFiles($input, $output);
			break;

		case 'expired':
			$this->executeExpired($input, $output);
			break;

		default:
			throw new \InvalidArgumentException('This task does not exists');
			break;		
	}
    }

    protected function executeDatabase(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Sync database');

	return $this;
    }

    protected function executeFiles(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Sync files');

	return $this;
    }

    protected function executeExpired(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Sync expired data');

	return $this;
    }

    protected function executeAll(InputInterface $input, OutputInterface $output)
    {
	$this->executeDatabase($input, $output)
	     ->executeFiles($input, $output)
             ->executeExpired($input, $output);

	return $this;
    }
}
