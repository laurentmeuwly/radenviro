<?php

namespace AppBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Filesystem\Filesystem;
use XMLReader;
use DOMDocument;

 
class SyncEnviraCommand extends ContainerAwareCommand
{
	private $tabStats;
	
	protected function configure()
    {
        // Name and description for app/console command
        $this
        ->setName('sync:envira')
        ->setDescription('Synchronize Envira into Radenviro')
		->addArgument('startDate')
		->addOption('type', null, InputOption::VALUE_OPTIONAL, 'Which data to be synchronized (all, new, mod).', 'all');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$syncService = $this->getContainer()->get('app.synchronizer');
		
		$startDate = $input->getArgument('startDate');
		$regex='#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#';
		if (preg_match($regex, $startDate)) {
			$startDate=$startDate;
		} else {
			$startDate=null;
		}

    	$type = $input->getOption('type');
    	switch ($type) {
    		// only new values will be imported
			case 'new':
			$text = 'Hello syncenvira(new):'.$startDate;
        $output->writeln($text);
    			//$result = $syncService->synchronize();
    			break;
    		
    		// only updated values will be imported
			case 'mod':
			$text = 'Hello syncenvira(mod):'.$startDate;
        $output->writeln($text);
    			break;
    			
    		// by default, all values will be imported
			default:
    			$result = $syncService->synchronize($startDate);
    			break;
    	}
    }
    
}