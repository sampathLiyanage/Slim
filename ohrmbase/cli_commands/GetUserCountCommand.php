<?php

/**
 * Created by PhpStorm.
 * User: buddhika
 * Date: 11/3/16
 * Time: 1:56 AM
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetUserCountCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:count-employees')

            // the short description shown while running "php bin/console list"
            ->setDescription('Prints employee count.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command gives you the employee count...")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs a message followed by a "\n"
        $output->writeln('Employee count is 10');

    }
}