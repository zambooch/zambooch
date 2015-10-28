<?php

namespace Wiki\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Wiki\MainBundle\Model\Wiki;
use Wiki\MainBundle\Model\WikiQuery;

class MainTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('main:test')
            ->setDescription('Тестирование функционала')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
                'yell',
                null,
                InputOption::VALUE_NONE,
                'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$output->writeln("test");
        /*
        $page = new Wiki();
        $page
            ->setAlias('root')
            ->setTitle('Главная')
            ->setText("главная страница")
            ->save();
        $page->makeRoot()->save();

        $child = new Wiki();
        $child
            ->setAlias('news')
            ->setTitle('Новости')
            ->setText("Новости сайта")
            ->save();
        $child->setParent($page)->save();

        var_dump($page, $child);
        */
       // $root = WikiQuery::create()->findOneByAlias('root');

        //$test = WikiQuery::create()->findOneByAlias('test');
        //$test->insertAsLastChildOf($root)->save();

       // $page_news = WikiQuery::create()->findOneByAlias('news');
       // $test2 = WikiQuery::create()->findOneByAlias('test2');
       // $test2->insertAsLastChildOf($page_news)->save();

        //$page_news->insertAsLastChildOf($root)->save();

        //dump($root->getChildren());



    }
}