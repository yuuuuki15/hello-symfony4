<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\Table;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

#[AsCommand(
    name: 'hello_world',
    description: 'Add a short description for your command',
)]
class HelloWorldCommand extends Command
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        
        $io->success('Hello World!');

        // SymfonyStyleのインスタンスを作成する
        $io = new SymfonyStyle($input, $output);

        // userテーブルのカラム名を取得する（例として、Doctrine ORMを使用する場合）
        // $entityManager = $this->getContainer()->get('doctrine')->getManager();
        // $entityManager = $this->getDoctrine()->getManager();
        $userMetadata = $this->entityManager->getClassMetadata(User::class);
        $columnNames = $userMetadata->getColumnNames();

        // Tableヘルパークラスを使用して、カラム名を表示する
        $table = new Table($io);
        $table->setHeaders(['Column Name']);
        $table->setRows(array_map(function($columnName) {
            return [$columnName];
        }, $columnNames));
        $table->render();

        return Command::SUCCESS;
    }
}
