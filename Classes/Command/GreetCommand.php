<?php
declare(strict_types=1);

namespace Nitsan\NsT3dev\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class GreetCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setHelp('This command greets a user. You can customize the greeting.')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?',
                'World'
            )
            ->addOption(
                'times',
                't',
                InputOption::VALUE_OPTIONAL,
                'How many times should we greet?',
                1
            )
            ->addOption(
                'yell',
                'y',
                InputOption::VALUE_NONE,
                'If set, the greeting will be in uppercase'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $name = $input->getArgument('name');
        $times = (int)$input->getOption('times');
        $yell = $input->getOption('yell');
        
        $io->title('Greeting Command - TYPO3 v13');
        $io->text(sprintf('Greeting %s %s time(s)', $name, $times));
        
        if ($yell) {
            $io->note('YELL mode activated!');
        }
        
        for ($i = 0; $i < $times; $i++) {
            $greeting = sprintf('Hello %s!', $name);
            
            if ($yell) {
                $greeting = strtoupper($greeting);
            }
            
            $io->text($greeting);
          
            if ($i === 0) {
                $this->logGreeting($name, $yell);
            }
        }
        
        $io->success('Greeting completed successfully!');
        
        return Command::SUCCESS;
    }
    
    private function logGreeting(string $name, bool $yell): void
    {
        $logMessage = sprintf('Greeted %s (yell: %s)', $name, $yell ? 'yes' : 'no');
        
       
        $logData = [
            'message' => $logMessage,
            'tstamp' => time(),
            'userid' => 0,
            'type' => 4, 
        ];
        
        $logFile = GeneralUtility::getFileAbsFileName('typo3temp/var/log/greetings.log');
        file_put_contents($logFile, date('Y-m-d H:i:s') . ': ' . $logMessage . PHP_EOL, FILE_APPEND);
    }
}