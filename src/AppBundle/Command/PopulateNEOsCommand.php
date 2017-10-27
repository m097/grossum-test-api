<?php

namespace AppBundle\Command;

use AppBundle\Service\Nasa\Repository\V1\Feed;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateNEOsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:populate:neos')
            ->setDescription('Populate Near-Earth Objects')
            ->addOption('period', null, InputOption::VALUE_OPTIONAL, 'Period in days', 3)
            ->addOption('clear', null, InputOption::VALUE_NONE, 'Clear NEOs collection')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start');
        $period = $input->getOption('period');
        if (!is_int($period) || $period < 0) {
            throw new \InvalidArgumentException('Invalid period value');
        }

        /** @var Feed $feedRepo */
        $feedRepo = $this->getContainer()->get('app.nasa.client')->getRepository('Feed');
        $feedResponse = $feedRepo->getLastFeed($input->getOption('period'));
        if (!$feedResponse->isSuccessful()) {
            $output->writeln('Request to nasa api failed');
            return;
        }

        $feed = $feedResponse->offsetGet('near_earth_objects');
        if (count($feed) == 0) {
            $output->writeln('Empty feed');
            return;
        }

        $neoRepo = $this->getContainer()
            ->get('doctrine_mongodb')
            ->getRepository('AppBundle:NearEarthObject');

        if ($input->getOption('clear')) {
            $neoRepo->clearAll();
            $output->writeln('NEOs collection cleared');
        }
        $proceed = $neoRepo->persistFromApi($feed);

        $output->writeln('Proceed NEOs: '.$proceed);
        $output->writeln('Finish');
    }

}
