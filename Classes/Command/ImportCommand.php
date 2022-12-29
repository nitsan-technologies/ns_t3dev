<?php
//declare(strict_types = 1);
namespace NITSAN\NsT3dev\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ImportCommand extends Command
{

    protected function configure()
    {
        $this
            ->addArgument(
                'pid',
                InputArgument::REQUIRED,
                'Parent ID'
            );
        $this
            ->addArgument(
                'csv',
                InputArgument::REQUIRED,
                'CSV File Path'
            );
    }
    /**
     * Initializes the command after the input has been bound and before the input is validated.
     *
     * @see InputInterface::input()
     * @see InputInterface::output()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Code Goes Here
        return COMMAND::SUCCESS;
    }

}
