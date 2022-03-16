<?php

namespace App\Command;

use Goutte\Client;
use App\Service\Scraping;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyScrapingCommand extends Command
{

    private $scraping;

    public function __construct(Scraping $scraping)
    {
        parent::__construct();

        $this->scraping = $scraping;
    }

    protected static $defaultName = 'app:scraping:daily';
    protected static $defaultDescription = 'Commande pour garder à jour la DB';

    protected function configure(): void
    {
        // $this
        //     ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
        //     ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        // ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Daily scraping loanch by command to maintain the DB updated
        $this->scraping->dailyScraping();


        // $io->success('DB mise à jour !');
        // $io->error('Un problème a été rencontré ! Echec du script !');

        return Command::SUCCESS;
    }
}
