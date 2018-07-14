<?php

namespace TheFox\PersonsBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class PersonsTestCommand extends Command
{
    protected static $defaultName = 'persons:test';

    protected function configure()
    {
        $this
            ->setDescription('Test')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');
        //
        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }
        //
        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $io->success('done');
    }
}
